<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassDiary;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\ClassRecord\Services\PdfReportService;
use Modules\Notebook\Services\GradeService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfReportController extends Controller
{
    /**
     * Download official diary PDF. Caller must ensure user owns the diary.
     */
    public function diary(ClassDiary $diary, PdfReportService $pdf): StreamedResponse
    {
        if ($diary->user_id !== auth()->id()) {
            abort(403);
        }
        if (! $diary->is_finalized) {
            abort(422, 'Apenas registros finalizados podem ser exportados em PDF.');
        }

        $diary->load(['schoolClass.school']);

        $user = auth()->user();
        $signatureDataUrl = null;
        if ($diary->signature_path && Storage::disk('local')->exists($diary->signature_path)) {
            $signatureDataUrl = 'data:image/png;base64,' . base64_encode(
                Storage::disk('local')->get($diary->signature_path)
            );
        } elseif ($user->signature_path && Storage::disk('local')->exists($user->signature_path)) {
            $mime = File::mimeType(Storage::disk('local')->path($user->signature_path));
            $signatureDataUrl = 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('local')->get($user->signature_path));
        }
        $logoDataUrl = null;
        if ($user->logo_path && Storage::disk('local')->exists($user->logo_path)) {
            $mime = File::mimeType(Storage::disk('local')->path($user->logo_path));
            $logoDataUrl = 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('local')->get($user->logo_path));
        }

        $pdfBytes = $pdf->generateFromView('classrecord::pdf.diary', [
            'diary' => $diary,
            'signatureDataUrl' => $signatureDataUrl,
            'logoDataUrl' => $logoDataUrl,
        ]);

        $filename = 'diario-' . $diary->id . '-' . now()->format('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($pdfBytes) {
            echo $pdfBytes;
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Download report card (grades) PDF for a class. Caller must ensure user owns the class.
     */
    public function reportCard(SchoolClass $schoolClass, GradeService $gradeService, PdfReportService $pdf): StreamedResponse
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $cycle = request()->integer('cycle', 1);
        $schoolClass->load('school');
        $rows = $gradeService->getGradesForClass($schoolClass, $cycle);

        $buckets = ['0-2' => 0, '2-4' => 0, '4-6' => 0, '6-8' => 0, '8-10' => 0];
        foreach ($rows as $row) {
            $avg = $row['average'];
            if ($avg === null) {
                continue;
            }
            if ($avg < 2) {
                $buckets['0-2']++;
            } elseif ($avg < 4) {
                $buckets['2-4']++;
            } elseif ($avg < 6) {
                $buckets['4-6']++;
            } elseif ($avg < 8) {
                $buckets['6-8']++;
            } else {
                $buckets['8-10']++;
            }
        }

        $user = auth()->user();
        $logoDataUrl = null;
        if ($user->logo_path && Storage::disk('local')->exists($user->logo_path)) {
            $mime = File::mimeType(Storage::disk('local')->path($user->logo_path));
            $logoDataUrl = 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('local')->get($user->logo_path));
        }

        $pdfBytes = $pdf->generateFromView('classrecord::pdf.report-card', [
            'schoolClass' => $schoolClass,
            'rows' => $rows,
            'cycle' => $cycle,
            'distribution' => $buckets,
            'logoDataUrl' => $logoDataUrl,
        ], true);

        $filename = 'boletim-' . $schoolClass->id . '-ciclo' . $cycle . '-' . now()->format('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($pdfBytes) {
            echo $pdfBytes;
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
