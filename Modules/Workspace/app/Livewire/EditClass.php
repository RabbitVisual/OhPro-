<?php

namespace Modules\Workspace\Livewire;

use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditClass extends Component
{
    public bool $modalOpen = false;
    public ?SchoolClass $class = null;
    public string $name = '';
    public string $grade_level = '';
    public string $subject = '';
    public string $color = '#6366f1';
    public bool $confirmingDeletion = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'grade_level' => 'nullable|string|max:50',
        'subject' => 'nullable|string|max:50',
        'color' => 'required|string|max:7',
    ];

    #[On('open-edit-class')]
    public function openModal($classId)
    {
        $this->reset(['modalOpen', 'confirmingDeletion']);

        $this->class = SchoolClass::find($classId);

        if (!$this->class || !$this->class->isOwner(Auth::user())) {
            // Security check
            return;
        }

        $this->name = $this->class->name;
        $this->grade_level = $this->class->grade_level ?? '';
        $this->subject = $this->class->subject ?? '';
        $this->color = $this->class->color ?? '#6366f1';
        $this->modalOpen = true;
    }

    public function save()
    {
        $this->validate();

        if (!$this->class || !$this->class->isOwner(Auth::user())) {
            return;
        }

        $this->class->update([
            'name' => $this->name,
            'grade_level' => $this->grade_level,
            'subject' => $this->subject,
            'color' => $this->color,
        ]);

        $this->modalOpen = false;
        $this->dispatch('class-updated'); // Refresh dashboard
        $this->redirect(route('dashboard'));
    }

    public function confirmDeletion()
    {
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if (!$this->class || !$this->class->isOwner(Auth::user())) {
            return;
        }

        $this->class->delete();

        $this->modalOpen = false;
        $this->dispatch('class-deleted');
        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('workspace::livewire.edit-class');
    }
}
