<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoreController extends Controller
{
    /**
     * Recursos: entry page with links to notifications and dashboard.
     */
    public function index(): View
    {
        return view('core::index');
    }

    /**
     * Create (no CRUD for core; redirect).
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }

    /**
     * Store (not used).
     */
    public function store(Request $request) {}

    /**
     * Show (no resource; redirect).
     */
    public function show($id): RedirectResponse
    {
        return redirect()->route('dashboard');
    }

    /**
     * Edit (no resource; redirect).
     */
    public function edit($id): RedirectResponse
    {
        return redirect()->route('dashboard');
    }

    /**
     * Update (not used).
     */
    public function update(Request $request, $id) {}

    /**
     * Remove (not used).
     */
    public function destroy($id) {}
}
