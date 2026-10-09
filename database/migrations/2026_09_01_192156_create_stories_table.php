<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug', 255)->unique();
            $table->json('title');
            $table->json('summary')->nullable();
            $table->json('what_happened')->nullable();
            $table->json('what_changed')->nullable();
            $table->json('sources_agree')->nullable();
            $table->json('sources_disagree')->nullable();
            $table->json('unconfirmed_claims')->nullable();
            $table->enum('evidence_level', ['high', 'moderate', 'low', 'unverified'])->default('unverified');
            $table->integer('evidence_score')->default(0);
            $table->integer('sources_count')->default(0);
            $table->integer('articles_count')->default(0);
            $table->integer('independent_sources_count')->default(0);
            $table->integer('importance_score')->default(0);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_published')->default(false);
            $table->json('countries')->nullable();
            $table->json('languages')->nullable();
            $table->json('tags')->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->timestamp('first_reported_at')->nullable();
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['is_trending', 'importance_score']);
            $table->index(['is_published', 'published_at']);
            $table->index('evidence_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
