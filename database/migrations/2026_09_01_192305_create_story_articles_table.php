<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->integer('relevance_score')->default(0);
            $table->enum('perspective', [
                'neutral',
                'supportive',
                'critical',
                'analytical',
                'official',
                'opposition'
            ])->default('neutral');
            $table->json('key_points')->nullable();
            $table->timestamps();

            $table->unique(['story_id', 'article_id']);
            $table->index(['story_id', 'relevance_score']);
            $table->index(['story_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_articles');
    }
};