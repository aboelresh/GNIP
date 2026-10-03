<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\StoryController;
use App\Http\Controllers\Web\BriefingController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\PreferencesController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

// ─── Public ───────────────────────────────────────────────────────────────────
Route::get('/',                [HomeController::class,    'index']);
Route::get('/stories/{story}', [StoryController::class,   'show']);
Route::get('/briefings',       [BriefingController::class,'index']);
Route::get('/briefings/{id}',  [BriefingController::class,'show']);
Route::get('/search',          [SearchController::class,  'index']);

// ─── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// ─── Protected ────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/preferences/sources', [PreferencesController::class, 'index']);
});