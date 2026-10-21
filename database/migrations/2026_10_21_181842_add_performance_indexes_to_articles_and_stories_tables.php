<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->index(['status', 'is_duplicate', 'published_at'], 'articles_status_dedup_date_idx');
            $table->index(['is_duplicate', 'source_id', 'published_at'], 'articles_dedup_source_date_idx');
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->index(['is_published', 'first_reported_at'], 'stories_published_reported_idx');
            $table->index(['category_id', 'is_published', 'importance_score'], 'stories_category_published_score_idx');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('articles_status_dedup_date_idx');
            $table->dropIndex('articles_dedup_source_date_idx');
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->dropIndex('stories_published_reported_idx');
            $table->dropIndex('stories_category_published_score_idx');
        });
    }
};