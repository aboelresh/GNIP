<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleRepository
{
    public function store(array $data): ?Article
    {
        try {
            // ─── Check URL duplicate ───────────────────────────────
            if (Article::where('url', $data['url'])->exists()) {
                return null;
            }

            // ─── Generate content hash ─────────────────────────────
            $contentHash = $this->generateHash(
                $data['title'],
                $data['description'] ?? ''
            );

            // ─── Check content hash duplicate ─────────────────────
            $existingByHash = Article::where('content_hash', $contentHash)
                ->where('source_id', '!=', $data['source_id'])
                ->first();

            $data['content_hash'] = $contentHash;

            if ($existingByHash) {
                $data['is_duplicate'] = true;
                $data['duplicate_of'] = $existingByHash->id;
                $data['status']       = 'processed';
            }

            return Article::create($data);

        } catch (\Exception $e) {
            Log::error('ArticleRepository::store failed: ' . $e->getMessage(), [
                'url' => $data['url'] ?? 'unknown',
            ]);
            return null;
        }
    }

    public function storeBatch(array $items, Source $source): array
    {
        $results = [
            'stored'     => 0,
            'duplicates' => 0,
            'failed'     => 0,
        ];

        foreach ($items as $item) {
            $article = $this->store($item);

            if ($article === null) {
                $results['duplicates']++;
                continue;
            }

            if ($article->is_duplicate) {
                $results['duplicates']++;
            } else {
                $results['stored']++;
            }
        }

        return $results;
    }

    public function getRawArticles(int $limit = 50)
    {
        return Article::with(['source', 'category'])
            ->where('status', 'raw')
            ->where('is_duplicate', false)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getForClustering(int $hours = 48, int $limit = 200)
    {
        return Article::with(['source'])
            ->where('status', 'processed')
            ->where('is_duplicate', false)
            ->whereNull('id', 'and', false)
            ->whereDoesntHave('stories')
            ->where('published_at', '>=', now()->subHours($hours))
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getSimilarArticles(Article $article, int $hours = 24)
    {
        return Article::with(['source'])
            ->where('id', '!=', $article->id)
            ->where('language', $article->language)
            ->where('is_duplicate', false)
            ->where('published_at', '>=', now()->subHours($hours))
            ->where(function ($query) use ($article) {
                $query->where('status', 'processed')
                    ->orWhere('status', 'raw');
            })
            ->limit(100)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total'      => Article::count(),
            'raw'        => Article::where('status', 'raw')->count(),
            'processing' => Article::where('status', 'processing')->count(),
            'processed'  => Article::where('status', 'processed')->count(),
            'failed'     => Article::where('status', 'failed')->count(),
            'duplicates' => Article::where('is_duplicate', true)->count(),
            'today'      => Article::where('published_at', '>=', now()->startOfDay())->count(),
        ];
    }

    private function generateHash(string $title, string $description = ''): string
    {
        $content = strtolower(trim($title . ' ' . $description));
        $content = preg_replace('/\s+/', ' ', $content);
        return hash('sha256', $content);
    }
}