<?php

namespace Modules\Workspace\Livewire;

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditSchool extends Component
{
    public bool $modalOpen = false;
    public ?School $school = null;
    public string $name = '';
    public string $color = '#6366f1';
    public bool $confirmingDeletion = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'color' => 'required|string|max:7',
    ];

    #[On('open-edit-school')]
    public function openModal($schoolId)
    {
        $this->reset(['modalOpen', 'confirmingDeletion']);

        $this->school = School::find($schoolId);

        if (!$this->school || $this->school->user_id !== Auth::id()) {
            // Security check: only owner can edit
            return;
        }

        $this->name = $this->school->name;
        $this->color = $this->school->color ?? '#6366f1';
        $this->modalOpen = true;
    }

    public function save()
    {
        $this->validate();

        if (!$this->school || $this->school->user_id !== Auth::id()) {
            return;
        }

        $this->school->update([
            'name' => $this->name,
            'color' => $this->color,
        ]);

        $this->modalOpen = false;
        $this->dispatch('school-updated'); // Refresh dashboard
        $this->redirect(route('dashboard')); // Force reload to update context/sidebar
    }

    public function confirmDeletion()
    {
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if (!$this->school || $this->school->user_id !== Auth::id()) {
            return;
        }

        // Optional: Check if it's the last school or has critical data?
        // For now, allow delete. Database cascading should handle relations if configured,
        // or SoftDeletes will hide it.

        $this->school->delete();

        // If current school was deleted, switch context
        if (session('workspace.current_school_id') == $this->school->id) {
            session()->forget('workspace.current_school_id');
            // Try to find another school
            $anotherSchool = Auth::user()->schools()->first();
            if ($anotherSchool) {
                session(['workspace.current_school_id' => $anotherSchool->id]);
            }
        }

        $this->modalOpen = false;
        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('workspace::livewire.edit-school');
    }
}
