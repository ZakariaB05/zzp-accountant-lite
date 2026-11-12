<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profielfoto', [ProfilePhotoController::class, 'edit'])->name('profile-photo.edit');
    Route::post('/profielfoto', [ProfilePhotoController::class, 'update'])->name('profile-photo.update');
    Route::delete('/profielfoto', [ProfilePhotoController::class, 'destroy'])->name('profile-photo.destroy');

    Route::resource('shifts', ShiftController::class)->except('show');
    Route::resource('trips', TripController::class)->except('show');
    Route::resource('expenses', ExpenseController::class)->except('show');
});

require __DIR__ . '/auth.php';