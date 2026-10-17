<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class QueueMonitor extends Command
{
    protected $signature = 'gnip:queue-monitor';

    protected $description = 'Display queue health: pending jobs, failed jobs, and worker status';

    public function handle(): int
    {
        $this->info('=== GNIP Queue Monitor ===');
        $this->newLine();

        // Pending jobs
        $pending = DB::table('jobs')
            ->selectRaw('queue, count(*) as count, min(created_at) as oldest')
            ->groupBy('queue')
            ->get();

        if ($pending->isEmpty()) {
            $this->line('<fg=green>✓ No pending jobs</fg=green>');
        } else {
            $this->warn('Pending Jobs:');
            $this->table(['Queue', 'Count', 'Oldest'], $pending->map(fn($j) => [
                $j->queue,
                $j->count,
                date('Y-m-d H:i:s', $j->oldest),
            ]));
        }

        $this->newLine();

        // Failed jobs
        $failed = DB::table('failed_jobs')
            ->selectRaw('queue, count(*) as count, max(failed_at) as latest_failure')
            ->groupBy('queue')
            ->get();

        if ($failed->isEmpty()) {
            $this->line('<fg=green>✓ No failed jobs</fg=green>');
        } else {
            $this->error('Failed Jobs:');
            $this->table(['Queue', 'Count', 'Latest Failure'], $failed->map(fn($j) => [
                $j->queue,
                $j->count,
                $j->latest_failure,
            ]));

            $this->newLine();
            $this->line('Run <fg=yellow>php artisan queue:retry all</fg=yellow> to retry failed jobs.');
            $this->line('Run <fg=yellow>php artisan queue:flush</fg=yellow> to clear failed jobs.');
        }

        $this->newLine();

        // Stats
        $totalPending = DB::table('jobs')->count();
        $totalFailed  = DB::table('failed_jobs')->count();

        $this->table(['Metric', 'Value'], [
            ['Total Pending', $totalPending],
            ['Total Failed', $totalFailed],
            ['Status', $totalFailed > 0 ? '⚠ Needs attention' : '✓ Healthy'],
        ]);

        return $totalFailed > 0 ? self::FAILURE : self::SUCCESS;
    }
}