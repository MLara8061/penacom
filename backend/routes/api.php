<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\AboutSectionController;
use App\Http\Controllers\API\HeroSectionController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\PortfolioItemController;
use App\Http\Controllers\API\LeadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\SiteSettingController;
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

// Formulario de contacto - lead público (sin autenticación)
Route::post('/leads', [LeadController::class, 'store']);

// Contenido de la página
Route::get('/hero-sections', [HeroSectionController::class, 'index']);
Route::get('/portfolio', [PortfolioItemController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/products/active', [ProductController::class, 'active']);

Route::get('/settings', function () {
    return SiteSetting::all()->mapWithKeys(function ($setting) {
        return [$setting->key => $setting->value];
    });
});

Route::get('/settings/footer', [SiteSettingController::class, 'footer']);

// TEMPORAL: Permitir actualización del footer sin auth para testing
// TODO: Mover dentro de auth:sanctum cuando se implemente login en el admin
Route::put('/settings/footer', [SiteSettingController::class, 'updateFooter']);

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

    // Hero Sections (Admin) - Solo rutas de escritura
    Route::get('/hero-sections/{hero_section}', [HeroSectionController::class, 'show']);
    Route::post('/hero-sections', [HeroSectionController::class, 'store']);
    Route::put('/hero-sections/{hero_section}', [HeroSectionController::class, 'update']);
    Route::delete('/hero-sections/{hero_section}', [HeroSectionController::class, 'destroy']);

    // Testimonials (Admin) - Solo rutas de escritura
    Route::get('/testimonials/{testimonial}', [TestimonialController::class, 'show']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);

    // Portfolio Items (Admin) - Solo rutas de escritura
    Route::get('/portfolio/{portfolio}', [PortfolioItemController::class, 'show']);
    Route::post('/portfolio', [PortfolioItemController::class, 'store']);
    Route::put('/portfolio/{portfolio}', [PortfolioItemController::class, 'update']);
    Route::delete('/portfolio/{portfolio}', [PortfolioItemController::class, 'destroy']);

    // Products (Admin) - Todas las rutas para admin
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    // Leads (Admin) - Gestión de leads del formulario
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{lead}', [LeadController::class, 'show']);
    Route::put('/leads/{lead}', [LeadController::class, 'update']);
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy']);

    // Contacts (Admin)
    Route::apiResource('contacts', ContactController::class);

    // Site settings
    // Route::put('/settings/footer', [SiteSettingController::class, 'updateFooter']); // Movido fuera de auth temporalmente

    // Users (Solo Admin)
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
    });
});
