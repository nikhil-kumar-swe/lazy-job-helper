<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobApplicationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [JobApplicationController::class, 'index'])->name('index');
        Route::get('/create', [JobApplicationController::class, 'create'])->name('create');
        Route::post('/', [JobApplicationController::class, 'store'])
            ->middleware('throttle:5,1')->name('store');
        Route::get('/{id}', [JobApplicationController::class, 'show'])
            ->whereNumber('id')->name('show');
        Route::delete('/{id}', [JobApplicationController::class, 'destroy'])
            ->whereNumber('id')->name('destroy');
    });
});

require __DIR__.'/auth.php';
