<?php

namespace Modules\Workspace\Livewire;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InviteTeacher extends Component
{
    public SchoolClass $schoolClass;
    public $email = '';
    public $message = '';

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    protected $messages = [
        'email.required' => 'O email é obrigatório.',
        'email.email' => 'Informe um email válido.',
        'email.exists' => 'Usuário não encontrado com este email.',
    ];

    public function invite()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        // Check if user is already the owner or a collaborator
        if ($this->schoolClass->isOwner($user)) {
             $this->addError('email', 'Este usuário é o proprietário desta turma.');
             return;
        }

        if ($this->schoolClass->isContributor($user)) {
            $this->addError('email', 'Este usuário já é um colaborador desta turma.');
            return;
        }

        // Attach user as contributor
        $this->schoolClass->teachers()->attach($user->id, ['role' => 'contributor']);

        // Log audit
        if (method_exists($this->schoolClass, 'audit')) {
            $this->schoolClass->audit('invited_teacher', [
                'invited_user_id' => $user->id,
                'invited_email' => $user->email,
            ]);
        }

        $this->reset(['email']);
        session()->flash('success', "Professor {$user->name} convidado com sucesso!");
        $this->dispatch('teacher-invited');
    }

    public function removeTeacher($userId)
    {
        // Only owner can remove
        if (!$this->schoolClass->isOwner(auth()->user())) {
            return;
        }

        $this->schoolClass->teachers()->detach($userId);

        // Log audit
        if (method_exists($this->schoolClass, 'audit')) {
            $this->schoolClass->audit('removed_teacher', ['removed_user_id' => $userId]);
        }

        session()->flash('success', 'Acesso do professor removido.');
    }

    public function render()
    {
        return view('workspace::livewire.invite-teacher', [
            'contributors' => $this->schoolClass->teachers,
        ]);
    }
}
