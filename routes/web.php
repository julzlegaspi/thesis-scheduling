<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\FacebookLoginController;
use App\Livewire\Dashboard;
use App\Livewire\TeamAndTitle;

Route::get('/', function () {
    return view('welcome');
});

// Guest route
Route::middleware(['guest'])->group(function () {
    Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
    
    Route::get('/facebook/redirect', [FacebookLoginController::class, 'redirectToFacebook'])->name('facebook.redirect');
    Route::get('/facebook/callback', [FacebookLoginController::class, 'handleFacebookCallback']);
});

// Authenticated route
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('/students')->group(function () {
        Route::get('/teams-and-titles', TeamAndTitle::class)->name('teams.and.titles.index');
    });
    
});

require __DIR__.'/auth.php';
