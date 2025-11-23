# API Routes - Laravel

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::get('/services/active', [ServiceController::class, 'active']);
Route::get('/schedules', [ScheduleController::class, 'index']);
Route::get('/contact', [ContactController::class, 'show']);

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
