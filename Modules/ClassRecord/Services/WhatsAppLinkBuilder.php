<?php

namespace Modules\ClassRecord\Services;

use App\Models\ClassDiary;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\URL;

class WhatsAppLinkBuilder
{
    /**
     * Build a short summary message for the diary PDF (no sensitive data beyond context).
     */
    public function buildMessageForDiary(ClassDiary $diary): string
    {
        $diary->loadMissing('schoolClass.school');
        $school = $diary->schoolClass->school->name ?? 'Escola';
        $class = $diary->schoolClass->name ?? 'Turma';
        $date = $diary->held_at?->translatedFormat('d/m/Y') ?? now()->format('d/m/Y');
        $title = $diary->content['title'] ?? 'Registro de aula';

        return "Registro de aula – {$title}\n{$school} – {$class}\nData: {$date}\n\nSegue o PDF em anexo (baixe pelo link abaixo).";
    }

    /**
     * Build a short summary message for the report card PDF.
     */
    public function buildMessageForReportCard(SchoolClass $schoolClass, int $cycle): string
    {
        $schoolClass->loadMissing('school');
        $school = $schoolClass->school->name ?? 'Escola';
        $class = $schoolClass->name ?? 'Turma';
        $count = $schoolClass->students()->count();

        return "Boletim – {$school} – {$class}\nCiclo: {$cycle}\nAlunos: {$count}\n\nSegue o PDF em anexo (baixe pelo link abaixo).";
    }

    /**
     * Build full WhatsApp link with pre-filled text (Brazil phone: 55 + DDD + number).
     */
    public function buildWhatsAppLink(string $phone, string $message): string
    {
        $clean = preg_replace('/\D/', '', $phone);
        if (strlen($clean) === 11 && str_starts_with($clean, '0') === false) {
            $clean = '55' . $clean;
        } elseif (strlen($clean) === 10) {
            $clean = '55' . $clean;
        } elseif (! str_starts_with($clean, '55') && strlen($clean) >= 10) {
            $clean = '55' . $clean;
        }
        $base = 'https://wa.me/' . $clean;
        $query = http_build_query(['text' => $message]);

        return $base . ($query ? '?' . $query : '');
    }

    /**
     * Generate a temporary signed URL for the diary PDF (e.g. 24h).
     */
    public function signedDiaryPdfUrl(ClassDiary $diary, int $minutes = 60 * 24): string
    {
        return URL::temporarySignedRoute(
            'diary.class.pdf.signed',
            now()->addMinutes($minutes),
            ['diary' => $diary->id]
        );
    }

    /**
     * Generate a temporary signed URL for the report card PDF.
     */
    public function signedReportCardPdfUrl(SchoolClass $schoolClass, int $cycle, int $minutes = 60 * 24): string
    {
        return URL::temporarySignedRoute(
            'notebook.report-card.pdf.signed',
            now()->addMinutes($minutes),
            ['schoolClass' => $schoolClass->id, 'cycle' => $cycle]
        );
    }
}
