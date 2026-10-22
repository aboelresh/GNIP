<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_fetch_source(): void
    {
        $admin  = User::factory()->admin()->create();
        $source = Source::factory()->create(['is_active' => true]);

        $response = $this->actingAs($admin)
            ->postJson("/api/v1/sources/{$source->id}/fetch");

        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_fetch_source(): void
    {
        $user   = User::factory()->create();
        $source = Source::factory()->create();

        $response = $this->actingAs($user)
            ->postJson("/api/v1/sources/{$source->id}/fetch");

        $response->assertStatus(403);
    }

    public function test_unauthenticated_cannot_fetch_source(): void
    {
        $source = Source::factory()->create();

        $response = $this->postJson("/api/v1/sources/{$source->id}/fetch");

        $response->assertStatus(401);
    }

    public function test_admin_can_analyze_article(): void
    {
        $admin   = User::factory()->admin()->create();
        $source  = Source::factory()->create();
        $article = Article::factory()->create(['source_id' => $source->id]);

        $response = $this->actingAs($admin)
            ->postJson("/api/v1/articles/{$article->id}/analyze");

        $this->assertContains($response->status(), [200, 503]);
        $response->assertJsonStructure(['status', 'message']);
    }

    public function test_rate_limiting_on_auth_routes(): void
    {
        for ($i = 0; $i < 11; $i++) {
            $response = $this->postJson('/api/v1/auth/login', [
                'email'    => 'test@example.com',
                'password' => 'wrong',
            ]);
        }

        $response->assertStatus(429);
    }

    public function test_dashboard_is_publicly_accessible(): void
    {
        $response = $this->getJson('/api/v1/dashboard');
        $response->assertStatus(200)->assertJsonStructure(['status', 'data']);
    }
}