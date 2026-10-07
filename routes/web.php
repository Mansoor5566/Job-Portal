<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\Employer\ApplicationController as EmployerApplicationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'home'])->name('home');

// Public job listings
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');

// Role-based dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Seeker
  Route::middleware('role:seeker')->group(function () {
    Route::get('/seeker/dashboard', [App\Http\Controllers\Seeker\DashboardController::class, 'index'])->name('seeker.dashboard');
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('seeker.applications');
    Route::get('/profile/seeker', [App\Http\Controllers\Seeker\ProfileController::class, 'edit'])->name('seeker.profile.edit');
    Route::post('/profile/seeker', [App\Http\Controllers\Seeker\ProfileController::class, 'update'])->name('seeker.profile.update');
});

    // Employer
Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
    
    Route::resource('jobs', EmployerJobController::class);
    Route::get('jobs/{job}/preview', [EmployerJobController::class, 'preview'])->name('jobs.preview');
    Route::get('applications', [EmployerApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{application}', [EmployerApplicationController::class, 'show'])->name('applications.show');
    Route::patch('applications/{application}/status', [EmployerApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('analytics', [App\Http\Controllers\Employer\AnalyticsController::class, 'index'])->name('analytics');
    Route::get('profile', [App\Http\Controllers\Employer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [App\Http\Controllers\Employer\ProfileController::class, 'update'])->name('profile.update');
});

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', AdminUserController::class)->only(['index', 'show', 'destroy']);
        Route::patch('users/{user}/toggle', [AdminUserController::class, 'toggle'])->name('users.toggle');
        Route::resource('jobs', AdminJobController::class)->only(['index', 'show', 'destroy']);
        Route::patch('jobs/{job}/toggle', [AdminJobController::class, 'toggle'])->name('jobs.toggle');
        Route::resource('categories', AdminCategoryController::class);
    });
});

require __DIR__ . '/auth.php';
