<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\AboutSectionController;
use App\Http\Controllers\API\HeroSectionController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\PortfolioItemController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\SiteSetting;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::get('/services/active', [ServiceController::class, 'active']);
Route::get('/schedules', [ScheduleController::class, 'index']);
Route::get('/contact', [ContactController::class, 'show']);
Route::get('/about', [AboutSectionController::class, 'show']);

// Contenido de la página
Route::get('/hero-sections', [HeroSectionController::class, 'index']);
Route::get('/portfolio', [PortfolioItemController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);

Route::get('/settings', function () {
    return SiteSetting::all()->mapWithKeys(function ($setting) {
        return [$setting->key => $setting->value];
    });
});

Route::get('/settings/{group}', function ($group) {
    return SiteSetting::where('group', $group)->get()->mapWithKeys(function ($setting) {
        return [$setting->key => $setting->value];
    });
});

// Autenticación
Route::post('/auth/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren autenticación con Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    
    // Services (Admin)
    Route::apiResource('services', ServiceController::class);
    Route::patch('/services/{id}/toggle-status', [ServiceController::class, 'toggleStatus']);
    
    // Schedules (Admin)
    Route::put('/schedules/bulk', [ScheduleController::class, 'bulkUpdate']);
    Route::apiResource('schedules', ScheduleController::class)->except(['store', 'destroy']);
    
    // Contact (Admin)
    Route::put('/contact', [ContactController::class, 'update']);
    
    // About Section (Admin)
    Route::put('/about', [AboutSectionController::class, 'update']);
    
    // Hero Sections (Admin)
    Route::apiResource('hero-sections', HeroSectionController::class);
    
    // Testimonials (Admin)
    Route::apiResource('testimonials', TestimonialController::class);
    
    // Portfolio Items (Admin)
    Route::apiResource('portfolio', PortfolioItemController::class);
});
