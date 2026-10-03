<?php

namespace App\Jobs\Feed;

use App\Models\Source;
use App\Repositories\ArticleRepository;
use App\Services\Feed\FeedFetcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchSourceFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 120;
    public int $backoff = 60;

    public function __construct(
        public readonly Source $source
    ) {}

    public function handle(FeedFetcher $fetcher, ArticleRepository $repository): void
    {
        Log::info("FetchSourceFeedJob started: [{$this->source->slug}]");

        if (! $this->source->is_active) {
            Log::warning("Source [{$this->source->slug}] is inactive. Skipping.");
            return;
        }

        if (! $this->source->isDueForFetch()) {
            Log::info("Source [{$this->source->slug}] not due for fetch yet. Skipping.");
            return;
        }

        // ─── Fetch items from RSS ──────────────────────────────────
        $items = $fetcher->fetch($this->source);

        if (empty($items)) {
            Log::warning("No items fetched from [{$this->source->slug}]");
            $this->source->markAsFetched();
            return;
        }

        // ─── Store articles ────────────────────────────────────────
        $results = $repository->storeBatch($items, $this->source);

        // ─── Mark source as fetched ────────────────────────────────
        $this->source->markAsFetched();

        Log::info("FetchSourceFeedJob done: [{$this->source->slug}]", [
            'fetched'    => count($items),
            'stored'     => $results['stored'],
            'duplicates' => $results['duplicates'],
            'failed'     => $results['failed'],
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("FetchSourceFeedJob failed: [{$this->source->slug}]", [
            'error' => $exception->getMessage(),
        ]);
    }
}