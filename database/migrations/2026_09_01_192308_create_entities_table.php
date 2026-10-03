<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', [
                'person',
                'organization',
                'country',
                'city',
                'military',
                'political_party',
                'company',
                'other'
            ])->default('other');
            $table->json('aliases')->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->json('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('slug');
        });

        Schema::create('article_entity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('entity_id')->constrained()->cascadeOnDelete();
            $table->enum('role', [
                'subject',
                'mentioned',
                'source',
                'actor',
                'victim',
                'location'
            ])->default('mentioned');
            $table->integer('relevance_score')->default(0);
            $table->timestamps();

            $table->unique(['article_id', 'entity_id']);
            $table->index('entity_id');
        });

        Schema::create('story_entity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->foreignId('entity_id')->constrained()->cascadeOnDelete();
            $table->enum('role', [
                'subject',
                'mentioned',
                'source',
                'actor',
                'victim',
                'location'
            ])->default('mentioned');
            $table->integer('relevance_score')->default(0);
            $table->timestamps();

            $table->unique(['story_id', 'entity_id']);
            $table->index('entity_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_entity');
        Schema::dropIfExists('article_entity');
        Schema::dropIfExists('entities');
    }
};