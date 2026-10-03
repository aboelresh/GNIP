<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_id')->index();
            $table->enum('platform', [
                'youtube',
                'other'
            ])->default('youtube');
            $table->string('url', 2048);
            $table->string('embed_url', 2048)->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail_url', 2048)->nullable();
            $table->string('channel_name')->nullable();
            $table->string('channel_id')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->string('language', 10)->default('en');
            $table->string('country_code', 5)->nullable();
            $table->text('transcript')->nullable();
            $table->json('ai_summary')->nullable();
            $table->integer('importance_score')->default(0);
            $table->boolean('is_processed')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['platform', 'external_id']);
            $table->index(['language', 'published_at']);
            $table->index('published_at');
        });

        Schema::create('story_video', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->foreignId('video_id')->constrained()->cascadeOnDelete();
            $table->integer('relevance_score')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->unique(['story_id', 'video_id']);
            $table->index('story_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_video');
        Schema::dropIfExists('videos');
    }
};