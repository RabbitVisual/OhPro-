<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Support\Models\Ticket;

class SupportController extends Controller
{
    /**
     * Display a listing of the user's tickets.
     */
    public function index(): View
    {
        $tickets = Ticket::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('support::index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create(): View
    {
        return view('support::create');
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:duvida,problema,sugestao,pagamento'],
            'description' => ['required', 'string', 'max:10000'],
        ], [], [
            'subject' => __('Assunto'),
            'category' => __('Categoria'),
            'description' => __('Detalhes'),
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $validated['subject'],
            'category' => $validated['category'],
            'message' => $validated['description'],
            'status' => 'open',
        ]);

        return redirect()->route('supports.index')->with('success', __('Chamado aberto com sucesso. Em breve nossa equipe responderá.'));
    }

    /**
     * Show the specified ticket.
     */
    public function show(string $id): View|RedirectResponse
    {
        $ticket = Ticket::where('user_id', auth()->id())->findOrFail($id);

        return view('support::show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified ticket (only if open).
     */
    public function edit(string $id): View|RedirectResponse
    {
        $ticket = Ticket::where('user_id', auth()->id())->findOrFail($id);

        if (! in_array($ticket->status, ['open', 'in_progress'], true)) {
            return redirect()->route('supports.show', $ticket)->with('info', __('Só é possível editar chamados em aberto.'));
        }

        return view('support::edit', compact('ticket'));
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $ticket = Ticket::where('user_id', auth()->id())->findOrFail($id);

        if (! in_array($ticket->status, ['open', 'in_progress'], true)) {
            return redirect()->route('supports.show', $ticket)->with('error', __('Só é possível editar chamados em aberto.'));
        }

        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
        ], [], [
            'subject' => __('Assunto'),
            'description' => __('Detalhes'),
        ]);

        $ticket->update([
            'subject' => $validated['subject'],
            'message' => $validated['description'],
        ]);

        return redirect()->route('supports.show', $ticket)->with('success', __('Chamado atualizado com sucesso.'));
    }

    /**
     * Remove the specified ticket (optional; not in plan).
     */
    public function destroy(string $id) {}
}
