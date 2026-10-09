<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('briefings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'daily',
                'weekly',
                'monthly',
                'yearly',
            ]);
            $table->enum('status', [
                'pending',
                'generating',
                'published',
                'failed',
            ])->default('pending');
            $table->json('title');
            $table->json('introduction')->nullable();
            $table->json('sections')->nullable();
            $table->json('conclusion')->nullable();
            $table->json('top_stories')->nullable();
            $table->json('key_developments')->nullable();
            $table->json('languages_available')->nullable();
            $table->date('period_start');
            $table->date('period_end');
            $table->integer('stories_count')->default(0);
            $table->integer('articles_count')->default(0);
            $table->integer('sources_count')->default(0);
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['type', 'period_start', 'period_end']);
            $table->index(['type', 'status']);
            $table->index(['type', 'published_at']);
        });

        Schema::create('briefing_story', function (Blueprint $table) {
            $table->id();
            $table->foreignId('briefing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->enum('section', [
                'politics',
                'conflicts',
                'economy',
                'technology',
                'science',
                'health',
                'sports',
                'environment',
                'international',
                'other',
            ])->default('other');
            $table->json('summary')->nullable();
            $table->timestamps();

            $table->unique(['briefing_id', 'story_id']);
            $table->index(['briefing_id', 'section']);
            $table->index(['briefing_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('briefing_story');
        Schema::dropIfExists('briefings');
    }
};
