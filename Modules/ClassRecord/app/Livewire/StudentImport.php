<?php

namespace Modules\ClassRecord\Livewire;

use App\Models\SchoolClass;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentImport extends Component
{
    use WithFileUploads;

    public $file = null;

    /** @var array<int, array<int, string>> */
    public array $previewRows = [];

    /** @var array{name: ?int, identifier: ?int} */
    public array $columnMap = ['name' => 0, 'identifier' => 1];

    public ?int $schoolClassId = null;

    public int $step = 1;

    protected function rules(): array
    {
        return [
            'file' => ['nullable', 'file', 'mimes:csv,txt', 'max:2048'],
            'columnMap.name' => ['required', 'integer', 'min:0'],
            'columnMap.identifier' => ['nullable', 'integer', 'min:0'],
            'schoolClassId' => ['required', 'integer', 'exists:school_classes,id'],
        ];
    }

    public function updatedFile(): void
    {
        $this->validateOnly('file');
        $this->parsePreview();
        $this->step = 2;
    }

    protected function parsePreview(): void
    {
        $this->previewRows = [];
        if (! $this->file) {
            return;
        }
        $path = $this->file->getRealPath();
        $handle = fopen($path, 'r');
        if (! $handle) {
            return;
        }
        $max = 10;
        $rowCount = 0;
        while (($row = fgetcsv($handle, 0, ',')) !== false && $rowCount < $max) {
            if (array_filter($row) !== []) {
                $this->previewRows[] = $row;
                $rowCount++;
            }
        }
        fclose($handle);
    }

    public function getClassesProperty()
    {
        return SchoolClass::with('school')
            ->where('user_id', auth()->id())
            ->orderBy('name')
            ->get();
    }

    public function import(): void
    {
        $this->validate([
            'columnMap.name' => ['required', 'integer', 'min:0'],
            'schoolClassId' => ['required', 'integer', 'exists:school_classes,id'],
        ]);

        $schoolClass = SchoolClass::find($this->schoolClassId);
        if (! $schoolClass || $schoolClass->user_id !== auth()->id()) {
            $this->dispatch('toast', message: 'Turma inválida.', type: 'error');
            return;
        }

        $this->dispatch('start-loading', message: 'Processando lista de alunos e organizando turmas...');

        try {
            $path = $this->file->getRealPath();
            $handle = fopen($path, 'r');
            if (! $handle) {
                $this->dispatch('stop-loading');
                $this->dispatch('toast', message: 'Erro ao ler o arquivo.', type: 'error');
                return;
            }

            $nameCol = (int) $this->columnMap['name'];
            $identifierCol = isset($this->columnMap['identifier']) && $this->columnMap['identifier'] !== '' && $this->columnMap['identifier'] !== null
                ? (int) $this->columnMap['identifier']
                : null;

            $created = 0;
            $attached = 0;

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                $name = trim($row[$nameCol] ?? '');
                if ($name === '') {
                    continue;
                }
                $identifier = $identifierCol !== null ? trim($row[$identifierCol] ?? '') : null;

                $identifierVal = is_string($identifier) && $identifier !== '' ? $identifier : null;
                $student = Student::withoutGlobalScope('user')
                    ->where('user_id', auth()->id())
                    ->when($identifierVal !== null, fn ($q) => $q->where('identifier', $identifierVal), fn ($q) => $q->where('name', $name))
                    ->first();

                if (! $student) {
                    $student = Student::create([
                        'user_id' => auth()->id(),
                        'name' => $name,
                        'identifier' => $identifierVal,
                    ]);
                    $created++;
                }

                if (! $student->schoolClasses()->where('school_class_id', $schoolClass->id)->exists()) {
                    $student->schoolClasses()->attach($schoolClass->id);
                    $attached++;
                }
            }

            fclose($handle);

            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: "Importação concluída. {$created} aluno(s) criado(s), {$attached} vínculo(s) na turma.", type: 'success');

            $this->reset(['file', 'previewRows', 'step']);
            $this->columnMap = ['name' => 0, 'identifier' => 1];
            $this->schoolClassId = null;
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: $e->getMessage() ?: 'Erro ao importar.', type: 'error');
        }
    }

    public function back(): void
    {
        $this->step = 1;
        $this->reset(['file', 'previewRows']);
        $this->columnMap = ['name' => 0, 'identifier' => 1];
    }

    public function render()
    {
        return view('classrecord::livewire.student-import');
    }
}
