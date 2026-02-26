<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index(): View
    {
        $notifications = auth()->user()->notifications()->paginate(20);

        return view('notifications::index', compact('notifications'));
    }

    /**
     * Create (not used; redirect).
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('notifications.index');
    }

    /**
     * Store (not used).
     */
    public function store(Request $request) {}

    /**
     * Show a single notification and mark as read.
     */
    public function show(string $id): View
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return view('notifications::show', compact('notification'));
    }

    /**
     * Edit (not used; redirect).
     */
    public function edit(string $id): RedirectResponse
    {
        return redirect()->route('notifications.index');
    }

    /**
     * Update (not used).
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove (not used).
     */
    public function destroy(string $id) {}
}
