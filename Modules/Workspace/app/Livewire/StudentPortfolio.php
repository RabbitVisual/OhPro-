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

    public bool $showGuestLinkModal = false;
    public string $guestLink = '';
    public ?string $guestTokenExpiry = null;

    public function mount(int $studentId): void
    {
        $this->studentId = $studentId;
        $student = Student::findOrFail($studentId);

        // Allow owner or if we implement shared students later
        // For now strict owner check is in place, but let's relax if needed or keep strictly owner
        if ($student->user_id !== auth()->id()) {
             // Check if user is a collaborator in any of the student's classes
             $hasAccess = $student->schoolClasses()
                ->whereHas('teachers', function($q) {
                    $q->where('users.id', auth()->id());
                })->exists();

             if (!$hasAccess) {
                 abort(403);
             }
        }
        $this->newOccurredAt = now()->format('Y-m-d\TH:i');
    }

    public function openGuestLinkModal()
    {
        $this->showGuestLinkModal = true;

        // Check for existing active token
        $token = \Modules\ClassRecord\Models\GuestAccessToken::where('student_id', $this->studentId)
            ->where('active', true)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if ($token) {
            $this->guestLink = route('portal.guest', $token->token);
            $this->guestTokenExpiry = $token->expires_at->format('d/m/Y');
        } else {
            $this->guestLink = '';
            $this->guestTokenExpiry = null;
        }
    }

    public function generateGuestLink()
    {
        $tokenStr = \Illuminate\Support\Str::random(32);

        \Modules\ClassRecord\Models\GuestAccessToken::create([
            'student_id' => $this->studentId,
            'token' => $tokenStr,
            'expires_at' => now()->addDays(30),
            'created_by' => auth()->id(),
            'active' => true,
        ]);

        $this->guestLink = route('portal.guest', $tokenStr);
        $this->guestTokenExpiry = now()->addDays(30)->format('d/m/Y');
        $this->dispatch('toast', message: 'Link gerado com sucesso!', type: 'success');
    }

    public function revokeGuestLink()
    {
        \Modules\ClassRecord\Models\GuestAccessToken::where('student_id', $this->studentId)
            ->update(['active' => false]);

        $this->guestLink = '';
        $this->guestTokenExpiry = null;
        $this->dispatch('toast', message: 'Link revogado.', type: 'info');
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
