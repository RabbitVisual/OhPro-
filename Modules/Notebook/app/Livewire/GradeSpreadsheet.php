<?php

namespace Modules\Notebook\Livewire;

use App\Models\SchoolClass;
use InvalidArgumentException;
use Livewire\Component;
use Modules\Notebook\Services\GradeService;

class GradeSpreadsheet extends Component
{
    public int $schoolClassId;

    public int $cycle = 1;

    public array $rows = [];

    protected GradeService $gradeService;

    public function boot(GradeService $gradeService): void
    {
        $this->gradeService = $gradeService;
    }

    public function mount(int $schoolClassId, int $cycle = 1): void
    {
        $this->schoolClassId = $schoolClassId;
        $this->cycle = $cycle;
        $this->loadRows();
    }

    public function loadRows(): void
    {
        $schoolClass = SchoolClass::findOrFail($this->schoolClassId);
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $this->rows = $this->gradeService->getGradesForClass($schoolClass, $this->cycle);
    }

    public function saveGrade(int $studentId, string $evaluationType, $value): void
    {
        $this->dispatch('start-loading', message: 'Salvando nota...');
        $score = $value === '' || $value === null ? null : (float) $value;
        try {
            $this->gradeService->save($studentId, $this->schoolClassId, $evaluationType, $score, $this->cycle);
            $this->loadRows();
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Nota salva!', type: 'success');
        } catch (InvalidArgumentException $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Erro ao salvar.', type: 'error');
        }
    }

    /**
     * Sync a batch of pending grades (e.g. after coming back online).
     */
    public function syncGrades(array $pending): void
    {
        $synced = 0;
        foreach ($pending as $item) {
            $studentId = (int) ($item['student_id'] ?? 0);
            $type = (string) ($item['evaluation_type'] ?? '');
            $value = $item['value'] ?? null;
            if ($studentId && in_array($type, ['av1', 'av2', 'av3'], true)) {
                try {
                    $this->gradeService->save(
                        $studentId,
                        $this->schoolClassId,
                        $type,
                        $value === '' || $value === null ? null : (float) $value,
                        $this->cycle
                    );
                    $synced++;
                } catch (\Throwable) {
                    // continue with next
                }
            }
        }
        $this->loadRows();
        if ($synced > 0) {
            $this->dispatch('toast', message: "{$synced} nota(s) sincronizada(s).", type: 'success');
        }
    }

    public function updatedCycle($value): void
    {
        $this->cycle = (int) $value;
        $this->loadRows();
    }

    public function render()
    {
        return view('notebook::livewire.grade-spreadsheet');
    }
}
