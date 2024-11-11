<?php

use App\Http\Controllers\api\LunchReservationController;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return redirect()->route('reservations.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // 予約関連のルート
    Route::resource('reservations', LunchReservationController::class);

    // 管理者用ルート
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });
});

require __DIR__.'/auth.php';
