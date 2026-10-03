<?php

namespace App\Console\Commands;

use App\Services\AI\AIManager;
use App\Services\Analysis\BriefingGeneratorService;
use Illuminate\Console\Command;

class GenerateBriefing extends Command
{
    protected $signature   = 'gnip:generate-briefing
                                {type=daily : Briefing type (daily/weekly/monthly)}';
    protected $description = 'Generate a news briefing using AI';

    public function handle(): int
    {
        $type = $this->argument('type');

        if (! in_array($type, ['daily', 'weekly', 'monthly'])) {
            $this->error("Invalid type. Use: daily, weekly, monthly");
            return self::FAILURE;
        }

        $this->info("📰 Generating {$type} briefing...");

        $aiManager = new AIManager();

        if (empty($aiManager->getAvailableProviders())) {
            $this->error('No AI providers available.');
            return self::FAILURE;
        }

        $service  = new BriefingGeneratorService($aiManager);

        $briefing = match($type) {
            'daily'   => $service->generateDaily(),
            'weekly'  => $service->generateWeekly(),
            'monthly' => $service->generateMonthly(),
        };

        if (! $briefing) {
            $this->error("Failed to generate {$type} briefing.");
            return self::FAILURE;
        }

        $this->line('');
        $this->info('═══════════════════════════════');
        $this->info("✅ Briefing generated!");
        $this->info("ID:      {$briefing->id}");
        $this->info("Type:    {$briefing->type}");
        $this->info("Stories: {$briefing->stories_count}");
        $this->info("Period:  {$briefing->period_start} → {$briefing->period_end}");
        $this->info('═══════════════════════════════');

        return self::SUCCESS;
    }
}