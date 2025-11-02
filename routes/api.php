<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::post('/student/login', [ApiController::class, 'loginStudent']);
Route::post('/student/sync-all', [ApiController::class, 'syncAll']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/student/sync-activity', [ApiController::class, 'syncActivity']);
    Route::post('/student/logout', [ApiController::class, 'logout']);
});
