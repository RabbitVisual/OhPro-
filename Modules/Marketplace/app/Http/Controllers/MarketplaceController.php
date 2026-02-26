<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Marketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Marketplace\Models\MarketplaceItem;

class MarketplaceController extends Controller
{
    /**
     * Display a listing of marketplace items (published + user's own).
     */
    public function index(Request $request): View
    {
        $query = MarketplaceItem::with('user:id,first_name,last_name')
            ->where(function ($q) {
                $q->where('status', 'published')
                    ->orWhere('user_id', auth()->id());
            })
            ->latest();

        if ($request->filled('mine') && $request->boolean('mine')) {
            $query->where('user_id', auth()->id());
        }

        $items = $query->paginate(20)->withQueryString();

        return view('marketplace::index', compact('items'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create(): View
    {
        return view('marketplace::create');
    }

    /**
     * Store a newly created item (draft).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
        ], [], [
            'title' => __('Título'),
            'description' => __('Descrição'),
            'price' => __('Preço'),
        ]);

        MarketplaceItem::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'status' => 'draft',
        ]);

        return redirect()->route('marketplace.index', ['mine' => 1])->with('success', __('Anúncio criado. Você pode publicá-lo ao editar.'));
    }

    /**
     * Show the specified item (published or own).
     */
    public function show(string $id): View
    {
        $item = MarketplaceItem::with(['user:id,first_name,last_name', 'reviews.user:id,first_name,last_name'])
            ->where(function ($q) {
                $q->where('status', 'published')->orWhere('user_id', auth()->id());
            })
            ->findOrFail($id);

        return view('marketplace::show', compact('item'));
    }

    /**
     * Show the form for editing the specified item (owner only).
     */
    public function edit(string $id): View|RedirectResponse
    {
        $item = MarketplaceItem::where('user_id', auth()->id())->findOrFail($id);

        return view('marketplace::edit', compact('item'));
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MarketplaceItem::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:draft,published,suspended'],
        ], [], [
            'title' => __('Título'),
            'description' => __('Descrição'),
            'price' => __('Preço'),
            'status' => __('Status'),
        ]);

        $item->update($validated);

        return redirect()->route('marketplace.show', $item)->with('success', __('Anúncio atualizado com sucesso.'));
    }

    /**
     * Remove the specified item (soft delete).
     */
    public function destroy(string $id) {}
}
