<?php

namespace App\Console\Commands;

use App\Models\Source;
use App\Repositories\ArticleRepository;
use App\Services\Feed\FeedFetcher;
use Illuminate\Console\Command;

class FetchFeeds extends Command
{
    protected $signature   = 'gnip:fetch-feeds {--source= : Fetch specific source by slug}';
    protected $description = 'Fetch news from all active RSS sources';

    public function handle(FeedFetcher $fetcher, ArticleRepository $repository): int
    {
        $this->info(' Starting feed fetch...');

        $query = Source::active()->whereNotNull('feed_url');

        if ($slug = $this->option('source')) {
            $query->where('slug', $slug);
        }

        $sources = $query->get();

        if ($sources->isEmpty()) {
            $this->warn('No active sources found.');
            return self::FAILURE;
        }

        $this->info("Found {$sources->count()} source(s).");

        $totalStored     = 0;
        $totalDuplicates = 0;
        $totalFailed     = 0;

        foreach ($sources as $source) {
            $this->line('');
            $this->line(" Fetching: <comment>{$source->name}</comment>");

            $items = $fetcher->fetch($source);

            if (empty($items)) {
                $this->warn("   No items fetched.");
                $source->markAsFetched();
                continue;
            }

            $results = $repository->storeBatch($items, $source);
            $source->markAsFetched();

            $totalStored     += $results['stored'];
            $totalDuplicates += $results['duplicates'];
            $totalFailed     += $results['failed'];

            $this->info("   Fetched: {$results['stored']} new | {$results['duplicates']} duplicates | {$results['failed']} failed");
        }

        $this->line('');
        $this->info('═══════════════════════════════');
        $this->info(" Total stored:     {$totalStored}");
        $this->info(" Total duplicates: {$totalDuplicates}");
        $this->info(" Total failed:     {$totalFailed}");
        $this->info('═══════════════════════════════');

        return self::SUCCESS;
    }
}