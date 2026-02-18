<?php

namespace Modules\Support\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Support\App\Models\Ticket;

class TicketManager extends Component
{
    use WithPagination;

    public $showCreateModal = false;

    public $showDetailModal = false;

    // Form fields
    public $subject;

    public $category = 'other';

    public $message;

    // Selected Ticket
    public $selectedTicket;

    protected $rules = [
        'subject' => 'required|string|max:255',
        'category' => 'required|in:billing,technical,suggestion,other',
        'message' => 'required|string|max:5000',
    ];

    public function render()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('support::livewire.ticket-manager', [
            'tickets' => $tickets,
        ]);
    }

    public function create()
    {
        $this->reset(['subject', 'category', 'message']);
        $this->showCreateModal = true;
    }

    public function store()
    {
        $this->validate();

        Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $this->subject,
            'category' => $this->category,
            'message' => $this->message,
            'status' => 'open',
        ]);

        $this->showCreateModal = false;
        $this->reset(['subject', 'category', 'message']);
        session()->flash('success', 'Ticket criado com sucesso!');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        $this->selectedTicket = $ticket;
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedTicket = null;
    }
}
