<?php

namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Support\App\Models\Ticket;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of support tickets.
     */
    public function index(Request $request): View
    {
        $query = Ticket::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->paginate(20);

        return view('support::admin.tickets.index', [
            'tickets' => $tickets,
            'title' => 'Gerenciar Tickets'
        ]);
    }

    /**
     * Display the specified ticket and reply form.
     */
    public function show(Ticket $ticket): View
    {
        return view('support::admin.tickets.show', [
            'ticket' => $ticket,
            'title' => 'Ticket #' . $ticket->id
        ]);
    }

    /**
     * Update the ticket with a reply.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'reply' => 'required|string',
            'status' => 'required|in:open,in_progress,answered,closed',
        ]);

        $ticket->update([
            'admin_reply' => $validated['reply'],
            'status' => $validated['status'],
            'replied_by' => auth()->id(),
            'replied_at' => now(),
        ]);

        return redirect()->route('panel.admin.tickets.show', $ticket)
            ->with('success', 'Resposta enviada com sucesso!');
    }
}
