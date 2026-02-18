<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Workspace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Modules\Diary\Services\ClassDiaryService;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('workspace::index');
    }

    /**
     * Show the specified class (single class view with Launch Class, grades, attendance).
     */
    public function show(SchoolClass $schoolClass)
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $diaryService = app(ClassDiaryService::class);
        $appliedPlan = $diaryService->getAppliedLessonPlan($schoolClass);
        return view('workspace::show', [
            'schoolClass' => $schoolClass,
            'appliedPlan' => $appliedPlan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workspace::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('workspace::edit');
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
