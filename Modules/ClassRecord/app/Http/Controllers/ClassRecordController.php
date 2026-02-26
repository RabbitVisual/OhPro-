<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassRecordController extends Controller
{
    /**
     * List teacher's classes with links to grades, attendance, workspace.
     */
    public function index(): View
    {
        $schoolClasses = SchoolClass::where('user_id', auth()->id())
            ->with('school:id,name')
            ->orderBy('name')
            ->get();

        return view('classrecord::index', compact('schoolClasses'));
    }

    /**
     * Create (turmas are created in Workspace; redirect).
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
     * Show a single class summary with links to grades, attendance, workspace.
     */
    public function show(string $id): View|RedirectResponse
    {
        $schoolClass = SchoolClass::where('user_id', auth()->id())
            ->with('school:id,name')
            ->findOrFail($id);

        return view('classrecord::show', compact('schoolClass'));
    }

    /**
     * Edit (redirect).
     */
    public function edit(string $id): RedirectResponse
    {
        return redirect()->route('classrecord.index');
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
