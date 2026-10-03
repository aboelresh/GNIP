<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function createUser(): User
    {
        return User::factory()->create(['role' => 'user']);
    }

    // ─── Admin routes ─────────────────────────────────────────────

    public function test_admin_can_access_fetch_source(): void
    {
        $admin  = $this->createAdmin();
        $source = Source::factory()->create([
            'is_active' => true,
            'feed_url'  => 'https://feeds.bbci.co.uk/news/world/rss.xml',
        ]);

        $response = $this->actingAs($admin)
            ->postJson("/api/v1/sources/{$source->id}/fetch");

        $response->assertStatus(200)
            ->assertJson(['status' => 'ok']);
    }

    public function test_regular_user_cannot_access_fetch_source(): void
    {
        $user   = $this->createUser();
        $source = Source::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)
            ->postJson("/api/v1/sources/{$source->id}/fetch");

        $response->assertStatus(403)
            ->assertJson([
                'status'  => 'error',
                'message' => 'Forbidden. Admin access required.',
            ]);
    }

    public function test_unauthenticated_user_cannot_access_fetch_source(): void
    {
        $source = Source::factory()->create(['is_active' => true]);

        $response = $this->postJson("/api/v1/sources/{$source->id}/fetch");

        $response->assertStatus(401);
    }

    public function test_admin_can_analyze_article(): void
{
    $admin   = $this->createAdmin();
    $source  = Source::factory()->create();
    $article = Article::factory()->create([
        'source_id' => $source->id,
        'status'    => 'raw',
    ]);

    $response = $this->actingAs($admin)
        ->postJson("/api/v1/articles/{$article->id}/analyze");

    // Admin should reach the endpoint (200 or 503 if AI unavailable)
    // The important thing is it's NOT 401 or 403
    $this->assertNotEquals(401, $response->status());
    $this->assertNotEquals(403, $response->status());
}

    public function test_regular_user_cannot_analyze_article(): void
    {
        $user    = $this->createUser();
        $source  = Source::factory()->create();
        $article = Article::factory()->create([
            'source_id' => $source->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/v1/articles/{$article->id}/analyze");

        $response->assertStatus(403);
    }

    // ─── Public routes accessible without auth ─────────────────────

    public function test_public_routes_accessible_without_auth(): void
    {
        $endpoints = [
            '/api/v1/dashboard',
            '/api/v1/categories',
            '/api/v1/articles',
            '/api/v1/stories',
            '/api/v1/briefings',
            '/api/v1/sources',
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->getJson($endpoint);
            $response->assertStatus(200);
        }
    }

    // ─── Non-existent resources ────────────────────────────────────

    public function test_returns_404_for_nonexistent_article(): void
    {
        $response = $this->getJson('/api/v1/articles/99999');

        $response->assertStatus(404)
            ->assertJson(['status' => 'error']);
    }

    public function test_returns_404_for_nonexistent_source(): void
    {
        $response = $this->getJson('/api/v1/sources/99999');

        $response->assertStatus(404)
            ->assertJson(['status' => 'error']);
    }

    public function test_returns_422_for_invalid_briefing_type(): void
    {
        $response = $this->getJson('/api/v1/briefings/latest/invalid_type');

        $response->assertStatus(422)
            ->assertJson(['status' => 'error']);
    }
}