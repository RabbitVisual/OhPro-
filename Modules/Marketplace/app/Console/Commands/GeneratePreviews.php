<?php

namespace Modules\Marketplace\Console\Commands;

use Illuminate\Console\Command;
use Modules\Marketplace\Models\MarketplaceItem;
use App\Jobs\GeneratePreviewJob;

class GeneratePreviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketplace:generate-previews {--all : Force regenerate all previews}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disaptch jobs to generate preview snapshots for Marketplace items.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = MarketplaceItem::query();

        if (!$this->option('all')) {
            $query->whereNull('preview_path');
        }

        $items = $query->get();

        $count = $items->count();
        if ($count === 0) {
            $this->info('No items need preview generation.');
            return;
        }

        $this->info("Dispatching preview generation for {$count} items...");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($items as $item) {
            GeneratePreviewJob::dispatch($item);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All jobs dispatched! Run "php artisan queue:work" to process them.');
    }
}
