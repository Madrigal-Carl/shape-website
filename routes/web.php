<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['role.redirect'])->group(function () {
    Route::get('/', [AuthController::class, 'authentication'])->name('authentication');

    Route::get('/instructor',[AuthController::class, 'instructorPanel'])->name('instructor.panel');

    Route::get('/admin', [AuthController::class, 'adminPanel'])->name('admin.panel');
});
