<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginForm']);
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $runs = $user->runs()->latest('run_date')->limit(5)->get();
        return view('dashboard', compact('runs'));
    })->name('dashboard');
    Route::get('/gps-run', [\App\Http\Controllers\GpsRunController::class, 'tracker'])->name('gps.tracker');
    Route::get('/gps-tracker', [\App\Http\Controllers\GpsRunController::class, 'tracker']);
    Route::post('/gps-run/save', [\App\Http\Controllers\GpsRunController::class, 'save'])->name('gps.save');
    Route::get('/runs/create', [\App\Http\Controllers\RunController::class, 'create'])->name('runs.create');
    Route::post('/runs', [\App\Http\Controllers\RunController::class, 'store'])->name('runs.store');
    Route::get('/runs', [\App\Http\Controllers\RunController::class, 'index'])->name('runs.index');
    Route::get('/runs/{run}/edit', [\App\Http\Controllers\RunController::class, 'edit'])->name('runs.edit');
    Route::put('/runs/{run}', [\App\Http\Controllers\RunController::class, 'update'])->name('runs.update');
    Route::delete('/runs/{run}', [\App\Http\Controllers\RunController::class, 'destroy'])->name('runs.destroy');
    Route::get('/progress', [\App\Http\Controllers\RunController::class, 'progress'])->name('progress');
    Route::resource('shoes', \App\Http\Controllers\ShoeController::class)->except(['show', 'create']);
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
