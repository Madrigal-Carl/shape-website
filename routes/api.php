<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::post('/student/login', [ApiController::class, 'loginStudent']);
Route::middleware('auth:sanctum')->post('/student/logout', [ApiController::class, 'logout']);
