<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ReportPdfMail;
use App\Models\ClassDiary;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\ClassRecord\Services\PdfReportService;
use Modules\Notebook\Services\GradeService;

class SendReportController extends Controller
{
    /**
     * Send report PDF (diary or report card) to an email address.
     */
    public function sendEmail(Request $request, PdfReportService $pdf, GradeService $gradeService): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:diary,report_card',
            'email' => 'required|email',
            'diary_id' => 'required_if:type,diary|nullable|integer|exists:class_diaries,id',
            'school_class_id' => 'required_if:type,report_card|nullable|integer|exists:school_classes,id',
            'cycle' => 'required_if:type,report_card|nullable|integer|min:1|max:4',
        ]);

        $user = $request->user();

        if ($validated['type'] === 'diary') {
            $diary = ClassDiary::findOrFail($validated['diary_id']);
            if ($diary->user_id !== $user->id) {
                abort(403);
            }
            if (! $diary->is_finalized) {
                return response()->json(['message' => 'Apenas registros finalizados podem ser enviados.'], 422);
            }
            [$pdfBytes, $filename, $subject, $body] = $this->buildDiaryPdf($diary, $pdf);
        } else {
            $schoolClass = SchoolClass::findOrFail($validated['school_class_id']);
            if ($schoolClass->user_id !== $user->id) {
                abort(403);
            }
            $cycle = (int) ($validated['cycle'] ?? 1);
            [$pdfBytes, $filename, $subject, $body] = $this->buildReportCardPdf($schoolClass, $cycle, $pdf, $gradeService);
        }

        Mail::to($validated['email'])->send(new ReportPdfMail($subject, $body, $pdfBytes, $filename));

        return response()->json(['message' => 'Relatório enviado por e-mail com sucesso.']);
    }

    /**
     * @return array{0: string, 1: string, 2: string, 3: string}
     */
    private function buildDiaryPdf(ClassDiary $diary, PdfReportService $pdf): array
    {
        $diary->load(['schoolClass.school']);
        $user = auth()->user();
        $signatureDataUrl = null;
        if ($diary->signature_path && Storage::disk('local')->exists($diary->signature_path)) {
            $signatureDataUrl = 'data:image/png;base64,' . base64_encode(Storage::disk('local')->get($diary->signature_path));
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
        $school = $diary->schoolClass->school->name ?? 'Escola';
        $class = $diary->schoolClass->name ?? 'Turma';
        $date = $diary->held_at?->translatedFormat('d/m/Y') ?? now()->format('d/m/Y');
        $subject = 'Registro de aula - ' . $date;
        $body = "Segue em anexo o registro de aula.\n\n{$school} – {$class}\nData: {$date}";

        return [$pdfBytes, $filename, $subject, $body];
    }

    /**
     * @return array{0: string, 1: string, 2: string, 3: string}
     */
    private function buildReportCardPdf(SchoolClass $schoolClass, int $cycle, PdfReportService $pdf, GradeService $gradeService): array
    {
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
        $school = $schoolClass->school->name ?? 'Escola';
        $class = $schoolClass->name ?? 'Turma';
        $subject = 'Boletim - ' . $class . ' - Ciclo ' . $cycle;
        $body = "Segue em anexo o boletim (notas).\n\n{$school} – {$class}\nCiclo: {$cycle}";

        return [$pdfBytes, $filename, $subject, $body];
    }
}
