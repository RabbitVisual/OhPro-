<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * Redireciona para o dashboard (área em desenvolvimento).
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard')->with('info', __('Esta área está em desenvolvimento.'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('dashboard')->with('info', __('Esta área está em desenvolvimento.'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id): RedirectResponse
    {
        return redirect()->route('dashboard')->with('info', __('Esta área está em desenvolvimento.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): RedirectResponse
    {
        return redirect()->route('dashboard')->with('info', __('Esta área está em desenvolvimento.'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
