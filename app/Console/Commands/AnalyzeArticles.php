<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\AI\AIManager;
use App\Services\AI\ArticleAnalyzer;
use Illuminate\Console\Command;

class AnalyzeArticles extends Command
{
    protected $signature = 'gnip:analyze-articles
                                {--limit=10 : Number of articles to analyze}
                                {--id= : Analyze specific article by ID}';

    protected $description = 'Analyze raw articles using AI';

    public function handle(): int
    {
        $aiManager = new AIManager();
        $analyzer = new ArticleAnalyzer($aiManager);

        $available = $aiManager->getAvailableProviders();

        if (empty($available)) {
            $this->warn(' No AI providers available.');
            $this->warn('  Install Ollama: https://ollama.ai');
            $this->warn('  Or set OPENAI_API_KEY in .env');

            return self::FAILURE;
        }

        $this->info(' AI Providers available: '.implode(', ', $available));
        $this->line('');

        // ─── Single article mode ───────────────────────────────────
        if ($id = $this->option('id')) {
            $article = Article::find($id);
            if (! $article) {
                $this->error("Article [{$id}] not found.");

                return self::FAILURE;
            }

            return $this->analyzeArticle($analyzer, $article);
        }

        // ─── Batch mode ────────────────────────────────────────────
        $limit = (int) $this->option('limit');
        $articles = Article::where('status', 'raw')
            ->where('is_duplicate', false)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        if ($articles->isEmpty()) {
            $this->warn('No raw articles found to analyze.');

            return self::SUCCESS;
        }

        $this->info("Found {$articles->count()} article(s) to analyze.");
        $this->line('');

        $success = 0;
        $failed = 0;

        $bar = $this->output->createProgressBar($articles->count());
        $bar->start();

        foreach ($articles as $article) {
            $result = $analyzer->analyze($article);
            $result ? $success++ : $failed++;
            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->line('');
        $this->info('═══════════════════════════════');
        $this->info(" Success: {$success}");
        $this->info(" Failed:  {$failed}");
        $this->info('═══════════════════════════════');

        return self::SUCCESS;
    }

    private function analyzeArticle(ArticleAnalyzer $analyzer, Article $article): int
    {
        $this->info("Analyzing: {$article->title}");
        $this->line("Source: {$article->source->name} | Language: {$article->language}");
        $this->line('');

        $result = $analyzer->analyze($article);

        if ($result) {
            $article->refresh();
            $this->info(' Analysis complete!');
            $this->line('Category:   '.($article->category?->getTranslatedName() ?? 'N/A'));
            $this->line("Importance: {$article->importance_score}/100");
            $this->line('Summary EN: '.($article->getAiSummary('en') ?? 'N/A'));
            $this->line('Summary AR: '.($article->getAiSummary('ar') ?? 'N/A'));
        } else {
            $this->error(' Analysis failed.');
        }

        return $result ? self::SUCCESS : self::FAILURE;
    }
}
