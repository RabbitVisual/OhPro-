<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Notebook\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotebookController extends Controller
{
    /**
     * Rubric builder (list and edit rubrics and levels).
     */
    public function rubrics(): View
    {
        return view('notebook::rubrics');
    }

    /**
     * Grade spreadsheet for a class.
     */
    public function grades(SchoolClass $schoolClass): View|RedirectResponse
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        return view('notebook::grades', ['schoolClass' => $schoolClass]);
    }

    /**
     * Quick attendance for a class.
     */
    public function attendance(SchoolClass $schoolClass): View|RedirectResponse
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        return view('notebook::attendance', ['schoolClass' => $schoolClass]);
    }

    /**
     * Caderno index: entry point with links to Rubricas, Notas and Chamada per class.
     */
    public function index(): View
    {
        $schoolClasses = SchoolClass::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('notebook::index', compact('schoolClasses'));
    }

    /**
     * Create (not used; redirect to index).
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('notebook.index');
    }

    /**
     * Store (not used).
     */
    public function store(Request $request) {}

    /**
     * Show (not used; redirect to index).
     */
    public function show($id): RedirectResponse
    {
        return redirect()->route('notebook.index');
    }

    /**
     * Edit (not used; redirect to index).
     */
    public function edit($id): RedirectResponse
    {
        return redirect()->route('notebook.index');
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
