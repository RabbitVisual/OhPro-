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
    public function generateFromView(string $view, array $data = [], bool $landscape = false): string
    {
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
