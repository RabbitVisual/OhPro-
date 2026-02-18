<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Notebook\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    /**
     * Rubric builder (list and edit rubrics and levels).
     */
    public function rubrics(): \Illuminate\View\View
    {
        return view('notebook::rubrics');
    }

    /**
     * Grade spreadsheet for a class.
     */
    public function grades(SchoolClass $schoolClass): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        return view('notebook::grades', ['schoolClass' => $schoolClass]);
    }

    /**
     * Quick attendance for a class.
     */
    public function attendance(SchoolClass $schoolClass): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        return view('notebook::attendance', ['schoolClass' => $schoolClass]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('notebook::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notebook::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('notebook::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('notebook::edit');
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
