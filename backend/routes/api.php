# API Routes - Laravel

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\HeroSection;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
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

// Contenido de la página
Route::get('/hero-sections', function () {
    return HeroSection::where('is_active', true)->orderBy('order')->get();
});

Route::get('/portfolio', function () {
    return PortfolioItem::orderBy('order')->orderBy('completed_date', 'desc')->get();
});

Route::get('/portfolio/featured', function () {
    return PortfolioItem::where('featured', true)->orderBy('order')->get();
});

Route::get('/testimonials', function () {
    return Testimonial::where('is_active', true)->get();
});

Route::get('/testimonials/featured', function () {
    return Testimonial::where('is_active', true)
        ->where('is_featured', true)
        ->get();
});

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
});
