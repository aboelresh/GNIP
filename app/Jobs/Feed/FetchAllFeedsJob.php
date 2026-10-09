<?php

namespace App\Jobs\Feed;

use App\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchAllFeedsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public int $timeout = 300;

    public function handle(): void
    {
        Log::info('FetchAllFeedsJob started.');

        $sources = Source::active()
            ->whereNotNull('feed_url')
            ->get();

        if ($sources->isEmpty()) {
            Log::warning('No active sources found.');

            return;
        }

        $dispatched = 0;

        foreach ($sources as $source) {
            if ($source->isDueForFetch()) {
                FetchSourceFeedJob::dispatch($source)
                    ->onQueue('feeds');
                $dispatched++;
            }
        }

        Log::info("FetchAllFeedsJob done. Dispatched: {$dispatched} jobs.");
    }
}
