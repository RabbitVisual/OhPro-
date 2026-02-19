<?php

namespace Modules\ClassRecord\Services;

use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

/**
 * Centralized PDF generation using Browsershot (headless Chrome).
 * Callers must enforce ownership (e.g. user_id) before passing data.
 */
class PdfReportService
{
    /**
     * Generate PDF bytes from a Blade view.
     *
     * @param  array<string, mixed>  $data
     */
    public function generateFromView(string $view, array $data = [], bool $landscape = false, array $options = []): string
    {
        // Inject theme if passed
        if (isset($data['theme']) && $data['theme'] instanceof \Modules\ClassRecord\Enums\PdfTheme) {
            // Theme is already an object
        } elseif (isset($data['theme']) && is_string($data['theme'])) {
             $data['theme'] = \Modules\ClassRecord\Enums\PdfTheme::tryFrom($data['theme']) ?? \Modules\ClassRecord\Enums\PdfTheme::CLASSIC;
        } else {
             $data['theme'] = \Modules\ClassRecord\Enums\PdfTheme::CLASSIC;
        }

        $html = View::make($view, $data)->render();

        $browsershot = Browsershot::html($html)
            ->format('A4')
            ->margins(10, 10, 10, 10, 'mm')
            ->emulateMedia('print')
            ->waitUntilNetworkIdle();

        if ($landscape) {
            $browsershot->landscape();
        }

        return $browsershot->pdf();
    }
}
