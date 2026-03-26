<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\AwardController;
use App\Http\Controllers\Api\CompetitionController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TopFlashController;
use App\Http\Controllers\Api\FormController;

/*
|--------------------------------------------------------------------------
| API Routes — Teachers of Bihar
|--------------------------------------------------------------------------
|
| Middlewares lagi hain:
|   api.log    → Sab requests log hoti hain (database mein)
|   api.secure → SQL injection + XSS block hota hai (sab routes pe)
|   api.key    → X-API-KEY header verify hoti hai (public routes pe)
|   auth:api   → Bearer token verify hota hai (protected routes pe)
|
| .env mein add karo:
|   API_KEYS=your-secret-key-123,another-key-456
|
*/

// ── Auth Routes — API Key chahiye ─────────────────
Route::middleware(['api.key'])->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login',  [AuthController::class, 'login']);
});

// ── Public Data Routes — API Key chahiye ──────────
Route::middleware(['api.key'])->group(function () {

    // Homepage
    Route::get('/sliders',  [SliderController::class,   'index']);
    Route::get('/topflash', [TopFlashController::class,  'index']);

    // News & Events
    Route::get('/news',        [NewsController::class, 'index']);
    Route::get('/news/{slug}', [NewsController::class, 'show']);

    // Publications
    Route::get('/publications',        [PublicationController::class, 'index']);
    Route::get('/publications/{slug}', [PublicationController::class, 'show']);

    // Gallery
    Route::get('/gallery',      [GalleryController::class, 'index']);
    Route::get('/gallery/{id}', [GalleryController::class, 'show']);

    // Team
    Route::get('/team',      [TeamController::class, 'index']);
    Route::get('/team/{id}', [TeamController::class, 'show']);

    // Awards
    Route::get('/awards',        [AwardController::class, 'index']);
    Route::get('/awards/{slug}', [AwardController::class, 'show']);

    // Competitions
    Route::get('/competitions',        [CompetitionController::class, 'index']);
    Route::get('/competitions/{slug}', [CompetitionController::class, 'show']);

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index']);

    // Forms
    Route::post('/contact',    [FormController::class, 'contactStore']);
    Route::post('/suggestion', [FormController::class, 'suggestionStore']);
    Route::post('/opinion',    [FormController::class, 'opinionStore']);
});

// ── Protected Routes — Bearer Token + API Key ─────
Route::middleware(['api.key', 'auth:api'])->group(function () {
    Route::get('/user',    [AuthController::class, 'userInfo']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
