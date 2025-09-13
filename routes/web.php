<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'landingPage'])
    ->name('landing.page');

// Only for guests (not authenticated)
Route::get('/auth', [AuthController::class, 'authentication'])
    ->middleware('role:guest')
    ->name('authentication');

// Only for authenticated instructors
Route::get('/instructor', [AuthController::class, 'instructorPanel'])
    ->middleware('role:instructor')
    ->name('instructor.panel');

// Only for authenticated admins
Route::get('/admin', [AuthController::class, 'adminPanel'])
    ->middleware('role:admin')
    ->name('admin.panel');
