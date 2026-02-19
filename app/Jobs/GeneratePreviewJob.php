<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GeneratePreviewJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public \Modules\Marketplace\app\Models\MarketplaceItem $item
    ) {}

    public function handle(): void
    {
        $path = 'market/previews/' . $this->item->id . '_' . time() . '.jpg';
        $fullPath = storage_path('app/public/' . $path);

        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        if ($this->item->lesson_plan_id && $this->item->lessonPlan) {
            $html = view('planning::pdf', [
                'plan' => $this->item->lessonPlan,
                'watermark_text' => 'PREVIEW',
            ])->render();

            // Add blur and watermark styles
            $html .= '<style>
                body { filter: blur(3px); overflow: hidden; transform: scale(0.8); transform-origin: top left; }
                .watermark { opacity: 0.5; font-size: 100px; }
            </style>';

            \Spatie\Browsershot\Browsershot::html($html)
                ->windowSize(800, 1100)
                ->setOption('args', ['--disable-web-security'])
                ->screenshot($fullPath);

            $this->item->update(['preview_path' => Storage::url($path)]);

        } elseif ($this->item->library_file_id && $this->item->libraryFile) {
             // For Library Files, if it's an image, we blur it.
             // If PDF or other, we might need a generic placeholder or advanced processing.
             $sourcePath = $this->item->libraryFile->path;

             if ($sourcePath && Storage::disk('public')->exists($sourcePath)) {
                 $mime = Storage::disk('public')->mimeType($sourcePath);

                 if (str_contains($mime, 'image')) {
                     // Simple image blur using GD
                     $image = imagecreatefromstring(Storage::disk('public')->get($sourcePath));
                     if ($image) {
                         for ($i = 0; $i < 40; $i++) {
                             imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
                         }
                         imagejpeg($image, $fullPath, 60); // Low quality
                         imagedestroy($image);
                         $this->item->update(['preview_path' => Storage::url($path)]);
                     }
                 }
             }
        }
    }
}
