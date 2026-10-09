<?php

namespace App\Services\AI;

use App\Models\Article;
use Illuminate\Support\Facades\Log;

class ArticleAnalyzer
{
    public function __construct(
        private readonly AIManager $ai
    ) {
    }

    public function analyze(Article $article): bool
    {
        $article->markAsProcessing();

        try {
            $classification = $this->classify($article);
            if (! $classification) {
                $article->markAsFailed();

                return false;
            }

            $summary = $this->summarize($article);

            $article->update([
                'category_id' => $classification['category_id'],
                'importance_score' => $classification['importance_score'],
                'ai_categories' => $classification['categories'],
                'ai_summary' => $summary,
                'status' => 'processed',
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error("ArticleAnalyzer failed [{$article->id}]: ".$e->getMessage());
            $article->markAsFailed();

            return false;
        }
    }

    private function classify(Article $article): ?array
    {
        $prompt = 'Classify this news article. Respond with ONLY a JSON object, no explanation, no markdown.

Title: '.$article->title.'
Description: '.($article->description ?? 'N/A').'

Return this exact JSON:
{"primary_category":"politics","importance_score":50,"categories":["politics"],"country_codes":["US"],"tags":["tag1"]}

Categories allowed: politics, conflicts, economy, technology, science, health, environment, sports, business, international
importance_score: 0-100 integer
country_codes: ISO alpha-2 codes';

        $response = $this->ai->completeAndLog(
            prompt: $prompt,
            operation: 'classification',
            subject: $article,
            options: ['temperature' => 0.1, 'max_tokens' => 200],
        );

        if (! $response->success) {
            return null;
        }

        $data = $this->parseJson($response->content);
        if (! $data) {
            Log::warning("Classification JSON parse failed for article [{$article->id}]: ".$response->content);

            return null;
        }

        $categorySlug = $data['primary_category'] ?? 'international';
        $category = \App\Models\Category::where('slug', $categorySlug)->first();

        return [
            'category_id' => $category?->id,
            'importance_score' => (int) ($data['importance_score'] ?? 30),
            'categories' => (array) ($data['categories'] ?? [$categorySlug]),
            'country_codes' => (array) ($data['country_codes'] ?? []),
            'tags' => (array) ($data['tags'] ?? []),
        ];
    }

    private function summarize(Article $article): array
    {
        $prompt = 'Summarize this news article. Respond with ONLY a JSON object.

Title: '.$article->title.'
Description: '.($article->description ?? $article->title).'
Source Language: '.$article->language.'

Return ONLY this JSON (no markdown, no explanation):
{"en":"2 sentence English summary","ar":"ملخص عربي في جملتين","fr":"Résumé en 2 phrases","it":"Riassunto in 2 frasi","es":"Resumen en 2 oraciones"}

Rules:
- Arabic summary is MANDATORY and must be in proper Arabic
- Be factual and neutral
- Maximum 2 sentences per language';

        $response = $this->ai->completeAndLog(
            prompt: $prompt,
            operation: 'summarization',
            subject: $article,
            options: ['temperature' => 0.1, 'max_tokens' => 600],
        );

        if (! $response->success) {
            return ['en' => $article->description ?? $article->title];
        }

        $data = $this->parseJson($response->content);

        if (! $data || ! isset($data['en'])) {
            return ['en' => $article->description ?? $article->title];
        }

        return $data;
    }

    private function parseJson(string $content): ?array
    {
        $content = trim($content);

        // Remove markdown code blocks
        $content = preg_replace('/^```(?:json)?\s*/i', '', $content);
        $content = preg_replace('/\s*```$/', '', $content);
        $content = trim($content);

        // Extract first JSON object
        if (preg_match('/\{[^{}]*(?:\{[^{}]*\}[^{}]*)?\}/s', $content, $matches)) {
            $content = $matches[0];
        }

        try {
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

            return is_array($data) ? $data : null;
        } catch (\JsonException $e) {
            // Try to fix common issues
            $content = preg_replace('/,\s*}/', '}', $content);
            $content = preg_replace('/,\s*]/', ']', $content);
            try {
                $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

                return is_array($data) ? $data : null;
            } catch (\JsonException $e2) {
                return null;
            }
        }
    }
}
