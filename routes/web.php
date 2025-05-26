<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SnapshotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [SnapshotController::class, 'index'])->name('dashboard');
    Route::post('/snapshots', [SnapshotController::class, 'store'])->name('snapshots.store');
    Route::get('/snapshots/{snapshot}/image', [SnapshotController::class, 'showImage'])->name('snapshots.image');

    Route::get('/photobooth', function () {
        return view('photobooth');
    })->name('photobooth');
});

require __DIR__ . '/auth.php';
