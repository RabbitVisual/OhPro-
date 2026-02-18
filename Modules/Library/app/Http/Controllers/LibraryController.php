<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LibraryFile;
use App\Models\LessonPlan;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LibraryController extends Controller
{
    /**
     * List current user's library files, optionally filtered by lesson plan or school class.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = LibraryFile::forUser($user->id)
            ->with(['lessonPlan:id,title', 'schoolClass:id,name']);

        if ($request->filled('lesson_plan_id')) {
            $query->where('lesson_plan_id', $request->integer('lesson_plan_id'));
        }
        if ($request->filled('school_class_id')) {
            $query->where('school_class_id', $request->integer('school_class_id'));
        }

        $files = $query->latest()->paginate(20);

        $lessonPlans = LessonPlan::where('user_id', $user->id())->orderBy('title')->get(['id', 'title']);
        $schoolClasses = SchoolClass::where('user_id', $user->id())->orderBy('name')->get(['id', 'name']);

        return view('library::index', [
            'files' => $files,
            'lessonPlans' => $lessonPlans,
            'schoolClasses' => $schoolClasses,
        ]);
    }

    /**
     * Store an uploaded file. Path: users/{user_id}/library/
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:51200'], // 50MB
            'lesson_plan_id' => ['nullable', 'integer', 'exists:lesson_plans,id'],
            'school_class_id' => ['nullable', 'integer', 'exists:school_classes,id'],
        ]);

        $user = $request->user();

        $lessonPlanId = $request->integer('lesson_plan_id') ?: null;
        $schoolClassId = $request->integer('school_class_id') ?: null;
        if ($lessonPlanId && LessonPlan::where('id', $lessonPlanId)->where('user_id', $user->id)->doesntExist()) {
            return redirect()->route('library.index')->with('error', __('Plano de aula inválido.'));
        }
        if ($schoolClassId && SchoolClass::where('id', $schoolClassId)->where('user_id', $user->id)->doesntExist()) {
            return redirect()->route('library.index')->with('error', __('Turma inválida.'));
        }

        if ($request->hasFile('file')) {
            $uploaded = $request->file('file');
            $dir = "users/{$user->id}/library";
            $path = $uploaded->store($dir, 'local');
            if ($path === false) {
                return redirect()->route('library.index')->with('error', __('Falha ao salvar o arquivo.'));
            }

            LibraryFile::create([
                'user_id' => $user->id,
                'name' => $uploaded->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $uploaded->getMimeType(),
                'size' => $uploaded->getSize(),
                'lesson_plan_id' => $lessonPlanId,
                'school_class_id' => $schoolClassId,
            ]);
        }

        return redirect()->route('library.index')->with('success', __('Arquivo enviado com sucesso.'));
    }

    /**
     * Secure download: only owner can download; stream file, no direct URL.
     */
    public function download(LibraryFile $libraryFile): StreamedResponse
    {
        if ($libraryFile->user_id !== auth()->id()) {
            abort(403);
        }

        if (! Storage::disk('local')->exists($libraryFile->path)) {
            abort(404, __('Arquivo não encontrado.'));
        }

        return Storage::disk('local')->download(
            $libraryFile->path,
            $libraryFile->name,
            ['Content-Type' => $libraryFile->mime_type ?? 'application/octet-stream']
        );
    }

    /**
     * Delete a library file (only owner).
     */
    public function destroy(LibraryFile $libraryFile)
    {
        if ($libraryFile->user_id !== auth()->id()) {
            abort(403);
        }

        Storage::disk('local')->delete($libraryFile->path);
        $libraryFile->delete();

        return redirect()->route('library.index')->with('success', __('Arquivo removido.'));
    }
}
