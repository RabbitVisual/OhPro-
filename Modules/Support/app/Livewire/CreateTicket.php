<?php

namespace Modules\Support\Livewire;

use Livewire\Component;
use Modules\Support\App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CreateTicket extends Component
{
    public $name;
    public $email;
    public $subject;
    public $category = 'other';
    public $message;

    protected function rules()
    {
        $rules = [
            'subject' => 'required|string|max:255',
            'category' => 'required|in:billing,technical,suggestion,other',
            'message' => 'required|string|max:5000',
        ];

        if (!Auth::check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        return $rules;
    }

    public function mount()
    {
        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    public function submit()
    {
        $this->validate();

        Ticket::create([
            'user_id' => Auth::id(),
            'guest_name' => Auth::check() ? null : $this->name,
            'guest_email' => Auth::check() ? null : $this->email,
            'subject' => $this->subject,
            'category' => $this->category,
            'message' => $this->message,
            'status' => 'open',
        ]);

        $this->reset(['subject', 'category', 'message']);

        if (!Auth::check()) {
             $this->reset(['name', 'email']);
        }

        session()->flash('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
    }

    public function render()
    {
        return view('support::livewire.create-ticket');
    }
}
