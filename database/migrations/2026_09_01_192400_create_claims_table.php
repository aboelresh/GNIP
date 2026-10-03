<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->json('text');
            $table->enum('status', [
                'unverified',
                'confirmed',
                'disputed',
                'debunked',
                'partially_confirmed'
            ])->default('unverified');
            $table->enum('importance', [
                'critical',
                'high',
                'medium',
                'low'
            ])->default('medium');
            $table->integer('confirmed_by_count')->default(0);
            $table->integer('disputed_by_count')->default(0);
            $table->integer('mentioned_by_count')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['story_id', 'status']);
            $table->index(['story_id', 'importance']);
        });

        Schema::create('claim_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrained()->cascadeOnDelete();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->enum('stance', [
                'confirms',
                'disputes',
                'mentions',
                'partially_confirms'
            ])->default('mentions');
            $table->text('excerpt')->nullable();
            $table->timestamps();

            $table->unique(['claim_id', 'article_id']);
            $table->index('claim_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claim_sources');
        Schema::dropIfExists('claims');
    }
};