<?php

namespace Modules\Manager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassDiary;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\ClassRecord\Services\AtRiskService;
use Modules\ClassRecord\Services\PdfReportService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ManagerDashboardController extends Controller
{
    /**
     * Manager home: list managed schools or redirect to single school dashboard.
     */
    public function index()
    {
        $schools = auth()->user()->managedSchools()->orderBy('name')->get();
        if ($schools->isEmpty()) {
            abort(403, 'Você não está vinculado a nenhuma escola.');
        }
        if ($schools->count() === 1) {
            return redirect()->route('manager.dashboard', $schools->first());
        }
        return view('manager::index', ['schools' => $schools]);
    }

    /**
     * Dashboard for one school (teachers, at-risk map, export diary).
     */
    public function dashboard(School $school, AtRiskService $atRiskService)
    {
        $this->ensureManagesSchool($school);

        $teacherIds = SchoolClass::where('school_id', $school->id)->distinct()->pluck('user_id');
        $teachers = \App\Models\User::whereIn('id', $teacherIds)->orderBy('first_name')->get(['id', 'first_name', 'last_name', 'email']);
        $cycle = request()->integer('cycle', 1);
        $atRisk = $atRiskService->getAtRiskListForSchool($school->id, $cycle);

        return view('manager::dashboard', [
            'school' => $school,
            'teachers' => $teachers,
            'atRisk' => $atRisk,
            'cycle' => $cycle,
        ]);
    }

    /**
     * Export consolidated diary PDF for the school (all classes, one month).
     */
    public function diaryPdf(Request $request, School $school, PdfReportService $pdf): StreamedResponse
    {
        $this->ensureManagesSchool($school);

        $month = $request->input('month', now()->format('Y-m'));
        [$year, $monthNum] = explode('-', $month);
        $start = "{$year}-{$monthNum}-01 00:00:00";
        $end = date('Y-m-t', strtotime($start)) . ' 23:59:59';

        $classIds = SchoolClass::where('school_id', $school->id)->pluck('id');
        $diaries = ClassDiary::whereIn('school_class_id', $classIds)
            ->where('is_finalized', true)
            ->whereBetween('scheduled_at', [$start, $end])
            ->with(['schoolClass', 'user'])
            ->orderBy('scheduled_at')
            ->get();

        $logoDataUrl = null;
        if ($school->logo_path && Storage::disk('local')->exists($school->logo_path)) {
            $mime = File::mimeType(Storage::disk('local')->path($school->logo_path));
            $logoDataUrl = 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('local')->get($school->logo_path));
        }

        $pdfBytes = $pdf->generateFromView('manager::pdf.diary-consolidated', [
            'school' => $school,
            'diaries' => $diaries,
            'month' => $month,
            'logoDataUrl' => $logoDataUrl,
        ]);

        $filename = 'diario-institucional-' . $school->id . '-' . $month . '.pdf';

        return response()->streamDownload(function () use ($pdfBytes) {
            echo $pdfBytes;
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    protected function ensureManagesSchool(School $school): void
    {
        $managed = auth()->user()->managedSchools()->where('schools.id', $school->id)->exists();
        if (! $managed) {
            abort(403, 'Você não gerencia esta escola.');
        }
    }
}
