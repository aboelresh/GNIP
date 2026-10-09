<?php

namespace App\Console\Commands;

use App\Services\AI\AIManager;
use App\Services\Analysis\StoryClusteringService;
use Illuminate\Console\Command;

class ClusterStories extends Command
{
    protected $signature = 'gnip:cluster-stories';

    protected $description = 'Cluster related articles into stories';

    public function handle(): int
    {
        $this->info(' Starting Story Clustering...');

        $aiManager = new AIManager();
        $service = new StoryClusteringService($aiManager);
        $results = $service->run();

        $this->line('');
        $this->info('═══════════════════════════════');
        $this->info(" Clusters found:      {$results['clusters']}");
        $this->info(" Stories created:     {$results['stories_created']}");
        $this->info(" Articles clustered:  {$results['articles_clustered']}");
        $this->info('═══════════════════════════════');

        return self::SUCCESS;
    }
}
