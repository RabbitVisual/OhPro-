<?php

namespace Modules\Workspace\Livewire;

use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateClass extends Component
{
    public bool $modalOpen = false;
    public string $name = '';
    public string $grade_level = '';
    public string $subject = '';
    public string $color = '#6366f1';
    public ?int $schoolId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'grade_level' => 'nullable|string|max:50',
        'subject' => 'nullable|string|max:50',
        'color' => 'required|string|max:7',
        'schoolId' => 'required|exists:schools,id',
    ];

    public function mount()
    {
        // Try to get school ID from session if not provided
        if (!$this->schoolId) {
            $this->schoolId = session('workspace.current_school_id');
        }
    }

    #[On('open-create-class')]
    public function openModal()
    {
        $this->reset(['name', 'grade_level', 'subject', 'color', 'modalOpen']);

        // Refresh school ID in case it changed
        $this->schoolId = session('workspace.current_school_id');

        if (!$this->schoolId) {
            $this->addError('schoolId', 'Nenhuma escola selecionada.');
            return;
        }

        $this->modalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $school = School::find($this->schoolId);

        if ($school->user_id !== $user->id) {
            abort(403);
        }

        // Check Plan Limits globally (total classes owned by user)
        // We count all classes in all schools owned by the user
        $totalClasses = SchoolClass::whereHas('school', fn($q) => $q->where('user_id', $user->id))->count();

        if (!$user->withinLimit('max_classes', $totalClasses)) {
            $this->addError('limit', 'Você atingiu o limite de turmas do seu plano. Faça upgrade para criar mais.');
            return;
        }

        SchoolClass::create([
            'school_id' => $this->schoolId,
            'name' => $this->name,
            'grade_level' => $this->grade_level,
            'subject' => $this->subject,
            'color' => $this->color,
        ]);

        $this->modalOpen = false;
        $this->dispatch('class-created'); // Refresh dashboard list
        $this->redirect(route('dashboard')); // Force reload
    }

    public function render()
    {
        return view('workspace::livewire.create-class');
    }
}
