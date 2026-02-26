<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Diary\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassDiary;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Modules\Diary\Services\ClassDiaryService;

class DiaryController extends Controller
{
    /**
     * Display a class diary (form to sign and finalize).
     */
    public function show(ClassDiary $diary)
    {
        if ($diary->user_id !== auth()->id()) {
            abort(403);
        }
        return view('diary::show', ['diary' => $diary]);
    }

    /**
     * Display diary index: recent class diaries and link to Workspace to start new ones.
     */
    public function index()
    {
        $user = auth()->user();
        $recentDiaries = ClassDiary::where('user_id', $user->id)
            ->with(['schoolClass:id,name,school_id', 'schoolClass.school:id,name'])
            ->latest('scheduled_at')
            ->take(15)
            ->get();
        return view('diary::index', ['recentDiaries' => $recentDiaries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diary::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Launch class: create ClassDiary from applied plan and redirect to diary form.
     */
    public function launch(SchoolClass $schoolClass, ClassDiaryService $service)
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $diary = $service->createFromAppliedPlan($schoolClass);
        return Redirect::route('diary.class.show', $diary)->with('success', 'Registro de aula iniciado. Assine para finalizar.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('diary::edit', ['id' => $id]);
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
