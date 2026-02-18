<?php

namespace Modules\Workspace\Livewire;

use App\Models\PortfolioEntry;
use App\Models\Student;
use App\Services\AiAssistantService;
use Livewire\Component;

class StudentPortfolio extends Component
{
    public int $studentId;

    public string $newTitle = '';

    public string $newContent = '';

    public string $newOccurredAt = '';

    public bool $showAddForm = false;

    public ?string $aiReport = null;

    public int $reportCycle = 1;

    public function mount(int $studentId): void
    {
        $this->studentId = $studentId;
        $student = Student::findOrFail($studentId);
        if ($student->user_id !== auth()->id()) {
            abort(403);
        }
        $this->newOccurredAt = now()->format('Y-m-d\TH:i');
    }

    public function getStudentProperty()
    {
        return Student::findOrFail($this->studentId);
    }

    public function getEntriesProperty()
    {
        return PortfolioEntry::withoutGlobalScope('teacher')
            ->where('student_id', $this->studentId)
            ->with(['schoolClass', 'libraryFile'])
            ->orderByDesc('occurred_at')
            ->get();
    }

    public function addObservation(): void
    {
        $this->validate([
            'newTitle' => 'required|string|max:200',
            'newContent' => 'nullable|string',
            'newOccurredAt' => 'required|date',
        ]);
        $this->dispatch('start-loading', message: 'Salvando...');
        PortfolioEntry::create([
            'student_id' => $this->studentId,
            'user_id' => auth()->id(),
            'school_class_id' => null,
            'type' => PortfolioEntry::TYPE_OBSERVATION,
            'title' => $this->newTitle,
            'content' => $this->newContent ?: null,
            'occurred_at' => $this->newOccurredAt,
        ]);
        $this->reset(['newTitle', 'newContent', 'showAddForm']);
        $this->newOccurredAt = now()->format('Y-m-d\TH:i');
        $this->dispatch('stop-loading');
        $this->dispatch('toast', message: 'Observação registrada.', type: 'success');
    }

    public function generateAiReport(): void
    {
        $this->dispatch('start-loading', message: 'Gerando relatório com IA...');
        try {
            $student = $this->student;
            $service = app(AiAssistantService::class);
            $this->aiReport = $service->generateStudentProgressReport($student, $this->reportCycle);
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Relatório gerado.', type: 'success');
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('workspace::livewire.student-portfolio');
    }
}
