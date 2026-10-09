<?php

use Illuminate\Support\Facades\Schedule;

// ─── Feed Fetching ─────────────────────────────────────────────────────────
Schedule::command('gnip:fetch-feeds')
    ->everyFifteenMinutes()
    ->withoutOverlapping()
    ->runInBackground();

// ─── Article Analysis ──────────────────────────────────────────────────────
Schedule::command('gnip:analyze-articles --limit=50')
    ->everyThirtyMinutes()
    ->withoutOverlapping()
    ->runInBackground();

// ─── Story Clustering ──────────────────────────────────────────────────────
Schedule::command('gnip:cluster-stories')
    ->hourly()
    ->withoutOverlapping()
    ->runInBackground();

// ─── Briefings ─────────────────────────────────────────────────────────────
Schedule::command('gnip:generate-briefing daily')
    ->dailyAt('00:30')
    ->withoutOverlapping();

Schedule::command('gnip:generate-briefing weekly')
    ->weeklyOn(1, '01:00')
    ->withoutOverlapping();

Schedule::command('gnip:generate-briefing monthly')
    ->monthlyOn(1, '02:00')
    ->withoutOverlapping();
