<?php

use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormSubmissionController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/technology', function () {
    return view('technology');
});

Route::get('/pricing', function () {
    return view('pricing');
});

Route::get('/clinics', function () {
    return view('clinics');
});

Route::get('/laserderme', function () {
    return view('laserderme');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/booking', [BookingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('booking.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/content', [ContentController::class, 'index'])->name('content.index');
        Route::get('/content/{page}', [ContentController::class, 'edit'])->name('content.edit');
        Route::put('/content/{page}', [ContentController::class, 'update'])->name('content.update');

        Route::get('/submissions', [FormSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [FormSubmissionController::class, 'show'])->name('submissions.show');
        Route::patch('/submissions/{submission}/status', [FormSubmissionController::class, 'updateStatus'])->name('submissions.status');
        Route::delete('/submissions/{submission}', [FormSubmissionController::class, 'destroy'])->name('submissions.destroy');

        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    });
