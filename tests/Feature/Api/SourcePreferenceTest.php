<?php

namespace Tests\Feature\Api;

use App\Models\Source;
use App\Models\User;
use App\Models\UserSourcePreference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SourcePreferenceTest extends TestCase
{
    use RefreshDatabase;

    // ─── Index ────────────────────────────────────────────────────

    public function test_authenticated_user_can_get_source_preferences(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/v1/preferences/sources');

        $response->assertStatus(200)
            ->assertJson(['status' => 'ok'])
            ->assertJsonStructure([
                'data' => [
                    'sources' => [
                        '*' => ['id', 'name', 'slug', 'language', 'bias', 'is_enabled']
                    ],
                    'total',
                    'enabled_count',
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_get_preferences(): void
    {
        $response = $this->getJson('/api/v1/preferences/sources');

        $response->assertStatus(401);
    }

   public function test_sources_default_to_enabled_when_no_preference_exists(): void
{
    $user    = User::factory()->create();
    $source1 = Source::factory()->create(['is_active' => true]);
    $source2 = Source::factory()->create(['is_active' => true]);

    $response = $this->actingAs($user)
        ->getJson('/api/v1/preferences/sources');

    $response->assertStatus(200);

    $sources = $response->json('data.sources');

    $this->assertNotEmpty($sources);

    foreach ($sources as $source) {
        $this->assertTrue($source['is_enabled'], "Source {$source['id']} should default to enabled");
    }
}

    // ─── Toggle ───────────────────────────────────────────────────

    public function test_user_can_disable_a_source(): void
    {
        $user   = User::factory()->create();
        $source = Source::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)
            ->putJson("/api/v1/preferences/sources/{$source->id}", [
                'is_enabled' => false,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
                'data'   => [
                    'source_id'  => $source->id,
                    'is_enabled' => false,
                ],
            ]);

        $this->assertDatabaseHas('user_source_preferences', [
            'user_id'    => $user->id,
            'source_id'  => $source->id,
            'is_enabled' => false,
        ]);
    }

    public function test_user_can_enable_a_source(): void
    {
        $user   = User::factory()->create();
        $source = Source::factory()->create(['is_active' => true]);

        // First disable it
        UserSourcePreference::create([
            'user_id'    => $user->id,
            'source_id'  => $source->id,
            'is_enabled' => false,
        ]);

        $response = $this->actingAs($user)
            ->putJson("/api/v1/preferences/sources/{$source->id}", [
                'is_enabled' => true,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.is_enabled', true);

        $this->assertDatabaseHas('user_source_preferences', [
            'user_id'    => $user->id,
            'source_id'  => $source->id,
            'is_enabled' => true,
        ]);
    }

    public function test_toggle_fails_without_is_enabled_field(): void
    {
        $user   = User::factory()->create();
        $source = Source::factory()->create();

        $response = $this->actingAs($user)
            ->putJson("/api/v1/preferences/sources/{$source->id}", []);

        $response->assertStatus(422);
    }

    public function test_toggle_fails_for_nonexistent_source(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->putJson('/api/v1/preferences/sources/99999', [
                'is_enabled' => false,
            ]);

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_toggle_source(): void
    {
        $source = Source::factory()->create();

        $response = $this->putJson("/api/v1/preferences/sources/{$source->id}", [
            'is_enabled' => false,
        ]);

        $response->assertStatus(401);
    }

    // ─── Bulk Update ──────────────────────────────────────────────

    public function test_user_can_bulk_update_preferences(): void
    {
        $user    = User::factory()->create();
        $source1 = Source::factory()->create();
        $source2 = Source::factory()->create();
        $source3 = Source::factory()->create();

        $response = $this->actingAs($user)
            ->putJson('/api/v1/preferences/sources', [
                'sources' => [
                    ['id' => $source1->id, 'enabled' => false],
                    ['id' => $source2->id, 'enabled' => false],
                    ['id' => $source3->id, 'enabled' => true],
                ],
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
                'data'   => ['updated' => 3],
            ]);

        $this->assertDatabaseHas('user_source_preferences', [
            'user_id'   => $user->id,
            'source_id' => $source1->id,
            'is_enabled' => false,
        ]);

        $this->assertDatabaseHas('user_source_preferences', [
            'user_id'   => $user->id,
            'source_id' => $source3->id,
            'is_enabled' => true,
        ]);
    }

    public function test_bulk_update_fails_with_invalid_source_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->putJson('/api/v1/preferences/sources', [
                'sources' => [
                    ['id' => 99999, 'enabled' => false],
                ],
            ]);

        $response->assertStatus(422);
    }

    // ─── Reset ────────────────────────────────────────────────────

    public function test_user_can_reset_preferences(): void
    {
        $user   = User::factory()->create();
        $source = Source::factory()->create();

        UserSourcePreference::create([
            'user_id'    => $user->id,
            'source_id'  => $source->id,
            'is_enabled' => false,
        ]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/preferences/sources');

        $response->assertStatus(200)
            ->assertJson(['status' => 'ok']);

        $this->assertDatabaseMissing('user_source_preferences', [
            'user_id' => $user->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_reset_preferences(): void
    {
        $response = $this->deleteJson('/api/v1/preferences/sources');

        $response->assertStatus(401);
    }

    // ─── Articles filtering ───────────────────────────────────────

    public function test_articles_exclude_disabled_sources(): void
    {
        $user    = User::factory()->create();
        $source1 = Source::factory()->create(['is_active' => true]);
        $source2 = Source::factory()->create(['is_active' => true]);

        \App\Models\Article::factory()->create([
            'source_id'    => $source1->id,
            'is_duplicate' => false,
        ]);

        \App\Models\Article::factory()->create([
            'source_id'    => $source2->id,
            'is_duplicate' => false,
        ]);

        // Disable source1
        UserSourcePreference::create([
            'user_id'    => $user->id,
            'source_id'  => $source1->id,
            'is_enabled' => false,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/v1/articles');

        $response->assertStatus(200);

        $sourceIds = collect($response->json('data'))->pluck('source.id')->unique()->toArray();

        $this->assertNotContains($source1->id, $sourceIds);
        $this->assertContains($source2->id, $sourceIds);
    }

    public function test_articles_show_all_sources_without_preferences(): void
    {
        $user    = User::factory()->create();
        $source1 = Source::factory()->create(['is_active' => true]);
        $source2 = Source::factory()->create(['is_active' => true]);

        \App\Models\Article::factory()->create([
            'source_id'    => $source1->id,
            'is_duplicate' => false,
        ]);

        \App\Models\Article::factory()->create([
            'source_id'    => $source2->id,
            'is_duplicate' => false,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/v1/articles');

        $response->assertStatus(200);

        $sourceIds = collect($response->json('data'))->pluck('source.id')->unique()->toArray();

        $this->assertContains($source1->id, $sourceIds);
        $this->assertContains($source2->id, $sourceIds);
    }
}