<?php

use App\Models\Student;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\StudentProgressReportMail;
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

// Email Testing Route (Only for Admins)
Route::get('/test-email', function () {
    $student = Student::first();

    $completed = 5;
    $remaining = 2;

    Mail::to('ericksongeroleo2003@gmail.com')->send(
        new StudentProgressReportMail($student, $completed, $remaining)
    );

    return "Test email sent!";
})->middleware('role:admin');
