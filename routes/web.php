<?php

use App\Livewire\User;
use App\Livewire\Course;
use App\Livewire\Section;
use App\Livewire\Dashboard;
use App\Livewire\TeamAndTitle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\FacebookLoginController;
use App\Http\Controllers\ViewManuscriptFileController;
use App\Livewire\Archive;
use App\Livewire\Schedule;
use App\Livewire\ScheduleDetail;
use App\Livewire\Venue;

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
    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    //Schedules
    Route::get('/schedules', Schedule::class)->name('schedules.index');
    Route::get('/schedules/details/{schedule}', ScheduleDetail::class)->middleware(['role:admin|secretary|student'])->name('schedule.show');

    //Admin
    Route::get('/courses', Course::class)->name('courses.index');
    Route::get('/sections', Section::class)->name('sections.index');
    Route::get('/users', User::class)->name('users.index');
    Route::get('/venues', Venue::class)->name('venues.index');
    Route::get('/archives', Archive::class)->name('archives.index');
    //Panelist


    //Secretary


    //Students
    Route::get('/teams-and-titles', TeamAndTitle::class)->middleware(['role:admin|student'])->name('teams.and.titles.index');
    
    //View file
    Route::post('/view-manuscript-file/{manuscript}', ViewManuscriptFileController::class)->middleware(['role:admin|secretary|student'])->name('manuscript.show');
});

require __DIR__.'/auth.php';
