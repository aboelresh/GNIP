<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Source;
use App\Repositories\ArticleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleIngestionTest extends TestCase
{
    use RefreshDatabase;

    // ─── Duplicate Detection ──────────────────────────────────────────────────

        public function test_duplicate_detected_by_url(): void
    {
        $source = Source::factory()->create();

        Article::factory()->create([
            'source_id' => $source->id,
            'url'       => 'https://example.com/article-1',
        ]);

        $isDuplicate = Article::where('url', 'https://example.com/article-1')->exists();

        $this->assertTrue($isDuplicate);
    }

    public function test_duplicate_detected_by_content_hash(): void
    {
        $source      = Source::factory()->create();
        $title       = 'Breaking News: Test Article';
        $description = 'This is a test description for duplicate detection.';
        $hash        = md5(strtolower(preg_replace('/\s+/', ' ', trim($title.' '.$description))));

        Article::factory()->create([
            'source_id'    => $source->id,
            'url'          => 'https://example.com/article-original',
            'title'        => $title,
            'description'  => $description,
            'content_hash' => $hash,
        ]);

        $isDuplicate = Article::where('content_hash', $hash)->exists();

        $this->assertTrue($isDuplicate);
    }

    public function test_unique_article_is_not_flagged_as_duplicate(): void
    {
        $uniqueUrl   = 'https://example.com/unique-'.uniqid();
        $isDuplicate = Article::where('url', $uniqueUrl)->exists();

        $this->assertFalse($isDuplicate);
    }

    // ─── Article Stats ────────────────────────────────────────────────────────

        public function test_article_stats_endpoint_returns_correct_structure(): void
    {
        $response = $this->getJson('/api/v1/articles/stats/overview');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'total',
                ],
            ]);
    }

    // ─── Article Filtering ────────────────────────────────────────────────────

    public function test_articles_can_be_filtered_by_language(): void
    {
        $source = Source::factory()->create();

        Article::factory()->create([
            'source_id'    => $source->id,
            'language'     => 'ar',
            'is_duplicate' => false,
        ]);

        Article::factory()->create([
            'source_id'    => $source->id,
            'language'     => 'en',
            'is_duplicate' => false,
        ]);

        $response = $this->getJson('/api/v1/articles?language=ar');

        $response->assertStatus(200);

        $languages = collect($response->json('data'))->pluck('language')->unique()->toArray();
        $this->assertEquals(['ar'], $languages);
    }

    public function test_duplicate_articles_are_excluded_from_feed(): void
    {
        $source = Source::factory()->create();

        Article::factory()->create([
            'source_id'    => $source->id,
            'is_duplicate' => true,
        ]);

        Article::factory()->create([
            'source_id'    => $source->id,
            'is_duplicate' => false,
        ]);

        $response = $this->getJson('/api/v1/articles');

        $response->assertStatus(200);

        $isDuplicates = collect($response->json('data'))->pluck('is_duplicate')->toArray();
        $this->assertNotContains(true, $isDuplicates);
    }

    public function test_articles_per_page_is_capped_at_100(): void
    {
        $response = $this->getJson('/api/v1/articles?per_page=999');

        $response->assertStatus(200);
        $this->assertLessThanOrEqual(100, $response->json('meta.per_page'));
    }
}