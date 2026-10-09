<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug', 255)->unique();
            $table->string('website_url');
            $table->string('feed_url')->nullable();
            $table->string('feed_type')->default('rss');
            $table->string('country_code', 5)->nullable();
            $table->string('language', 10)->default('en');
            $table->string('logo_url')->nullable();
            $table->enum('bias', ['left', 'center-left', 'center', 'center-right', 'right', 'state', 'unknown'])->default('unknown');
            $table->enum('type', ['wire_agency', 'newspaper', 'tv_channel', 'digital', 'government', 'ngo', 'other'])->default('other');
            $table->integer('reliability_score')->default(50);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_free')->default(true);
            $table->integer('fetch_interval_minutes')->default(15);
            $table->timestamp('last_fetched_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
