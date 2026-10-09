<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_id')->nullable();
            $table->string('url')->unique();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('author')->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->string('language', 10)->default('en');
            $table->string('country_code', 5)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->enum('status', ['raw', 'processing', 'processed', 'failed'])->default('raw');
            $table->string('content_hash', 64)->nullable()->index();
            $table->boolean('is_duplicate')->default(false);
            $table->unsignedBigInteger('duplicate_of')->nullable();
            $table->integer('importance_score')->default(0);
            $table->json('ai_summary')->nullable();
            $table->json('ai_categories')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['source_id', 'published_at']);
            $table->index(['language', 'published_at']);
            $table->index(['status', 'published_at']);
            $table->index('published_at');
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
