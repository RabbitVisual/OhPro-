<?php

namespace Modules\Workspace\Livewire;

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateSchool extends Component
{
    public bool $modalOpen = false;
    public string $name = '';
    public string $color = '#6366f1';

    protected $rules = [
        'name' => 'required|string|max:255',
        'color' => 'required|string|max:7',
    ];

    #[On('open-create-school')]
    public function openModal()
    {
        $this->reset(['name', 'color', 'modalOpen']);
        $this->modalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        // Check Plan Limits
        if (!$user->withinLimit('max_schools', $user->schools()->count())) {
            $this->addError('limit', 'Você atingiu o limite de escolas do seu plano. Faça upgrade para criar mais.');
            return;
        }

        $school = School::create([
            'user_id' => $user->id,
            'name' => $this->name,
            'color' => $this->color,
        ]);

        // If this is the first school, set as current
        if ($user->schools()->count() === 1) {
            session(['workspace.current_school_id' => $school->id]);
        }

        $this->modalOpen = false;
        $this->dispatch('school-created'); // Refresh dashboard
        $this->redirect(route('dashboard')); // Force reload to update sidebar/context
    }

    public function render()
    {
        return view('workspace::livewire.create-school');
    }
}
