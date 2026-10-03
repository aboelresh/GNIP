<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_logs', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('model');
            $table->enum('operation', [
                'classification',
                'summarization',
                'entity_extraction',
                'claim_extraction',
                'clustering',
                'importance_scoring',
                'briefing_generation',
                'translation',
                'video_summary',
                'cross_source_analysis'
            ]);
            $table->morphs('subject');
            $table->enum('status', [
                'success',
                'failed',
                'timeout',
                'limit_reached'
            ])->default('success');
            $table->integer('prompt_tokens')->default(0);
            $table->integer('completion_tokens')->default(0);
            $table->integer('total_tokens')->default(0);
            $table->float('duration_seconds')->default(0);
            $table->float('cost')->default(0);
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['provider', 'status']);
            $table->index(['operation', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_logs');
    }
};