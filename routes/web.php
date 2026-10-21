<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BriefingController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PreferencesController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\StoryController;
use Illuminate\Support\Facades\Route;

// ─── Public ───────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class,    'index']);
Route::get('/stories/{story}', [StoryController::class,   'show']);
Route::get('/briefings', [BriefingController::class, 'index']);
Route::get('/briefings/{id}', [BriefingController::class, 'show']);
Route::get('/search', [SearchController::class,  'index']);
Route::post('/locale', function (Illuminate\Http\Request $request) {
    $request->validate(['locale' => 'required|in:ar,en,fr']);
    session(['locale' => $request->locale]);
    return back();
});

// ─── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// ─── Protected ────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/preferences/sources', [PreferencesController::class, 'index']);
    Route::put('/preferences/sources/{source}', [PreferencesController::class, 'toggle']);
    Route::delete('/preferences/sources', [PreferencesController::class, 'reset']);
});
