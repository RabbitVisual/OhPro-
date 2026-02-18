<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassDiary;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClassRecord\Services\WhatsAppLinkBuilder;

class ShareReportController extends Controller
{
    public function __construct(
        private WhatsAppLinkBuilder $whatsApp
    ) {}

    /**
     * Get share data for diary (message + signed PDF URL) for WhatsApp.
     */
    public function shareDiary(ClassDiary $diary): JsonResponse
    {
        if ($diary->user_id !== auth()->id()) {
            abort(403);
        }
        if (! $diary->is_finalized) {
            return response()->json(['message' => 'Apenas registros finalizados podem ser compartilhados.'], 422);
        }

        $message = $this->whatsApp->buildMessageForDiary($diary);
        $pdfUrl = $this->whatsApp->signedDiaryPdfUrl($diary);
        $fullMessage = $message . "\n\n" . $pdfUrl;

        return response()->json([
            'message' => $fullMessage,
            'pdf_url' => $pdfUrl,
        ]);
    }

    /**
     * Get share data for report card (message + signed PDF URL).
     */
    public function shareReportCard(Request $request, SchoolClass $schoolClass): JsonResponse
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $cycle = $request->integer('cycle', 1);

        $message = $this->whatsApp->buildMessageForReportCard($schoolClass, $cycle);
        $pdfUrl = $this->whatsApp->signedReportCardPdfUrl($schoolClass, $cycle);
        $fullMessage = $message . "\n\n" . $pdfUrl;

        return response()->json([
            'message' => $fullMessage,
            'pdf_url' => $pdfUrl,
        ]);
    }
}
