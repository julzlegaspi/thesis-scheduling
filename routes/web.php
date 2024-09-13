<?php

use App\Http\Controllers\DownloadTempUser;
use App\Livewire\User;
use App\Livewire\Venue;
use App\Livewire\Course;
use App\Livewire\Archive;
use App\Livewire\Section;
use App\Livewire\Approval;
use App\Livewire\Schedule;
use App\Livewire\Dashboard;
use App\Livewire\CourseDetail;
use App\Livewire\TeamAndTitle;
use App\Livewire\ScheduleDetail;
use App\Livewire\CompleteProfile;
use App\Livewire\CreateTeamAndTitle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ViewRscFileController;
use App\Http\Controllers\FacebookLoginController;
use App\Http\Controllers\ViewManuscriptFileController;
use App\Livewire\EditTeamAndTitle;

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
Route::middleware(['auth', 'verified', 'ensure_student_has_course_and_section'])->group(function() {
    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    //Schedules
    Route::get('/schedules', Schedule::class)->name('schedules.index');
    Route::get('/schedules/details/{schedule}', ScheduleDetail::class)->name('schedule.show');

    //Admin
    Route::get('/courses', Course::class)->name('courses.index');
    Route::get('/course/{course}', CourseDetail::class)->name('course.show');
    Route::get('/sections', Section::class)->name('sections.index');
    Route::get('/users', User::class)->name('users.index');
    Route::get('/venues', Venue::class)->name('venues.index');
    Route::get('/archives', Archive::class)->name('archives.index');
    //Panelist
    Route::get('/approvals', Approval::class)->middleware('role:panelist')->name('approvals.index');

    //Secretary


    //Students
    Route::prefix('/teams-and-titles')->middleware(['role:admin|student'])->group(function () {
        Route::get('/', TeamAndTitle::class)->middleware(['role:admin|student'])->name('teams.and.titles.index');
        Route::get('/create', CreateTeamAndTitle::class)->name('teams.and.titles.create');
        Route::get('/{team}/edit', EditTeamAndTitle::class)->name('teams.and.titles.edit');
    });

    
    //View file
    Route::post('/view-manuscript-file/{manuscript}', ViewManuscriptFileController::class)->name('manuscript.show');
    Route::post('/view-rsc-file/{rsc}', ViewRscFileController::class)->name('rsc.show');

    //Download temp users
    Route::get('/download-temp-users', DownloadTempUser::class)->name('download.temp.users');
});

Route::get('/complete-profile', CompleteProfile::class)->name('complete.profile.index');

require __DIR__.'/auth.php';
