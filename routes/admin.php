<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;

// đã có ->as('admin.') ở app.php nên ->name('dashboard') sẽ thành 'admin.dashboard'
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/chart', [DashboardController::class, 'chartData'])->name('dashboard.chart');
//
Route::resource('categories', CategoryController::class);
Route::resource('services', AdminServiceController::class);
Route::resource('employees', EmployeeController::class);

Route::get('/search', [DashboardController::class, 'search'])->name('admin.search');

// Group cho in4 của Admin
Route::prefix('profile')->group(function () {
    // admin.profile
    Route::get('/', [ProfileController::class, 'adminProfile'])->name('profile.index');    
    // admin.profile.update
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    // admin.profile.password
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Group cho Appointment của Admin
Route::prefix('appointments')->as('appointments.')->group(function () {
    Route::get('/', [AdminAppointmentController::class, 'index'])->name('index');
    Route::get('/{appointment}', [AdminAppointmentController::class, 'show'])->name('show');
    Route::post('/{appointment}/confirm', [AdminAppointmentController::class, 'confirm'])->name('confirm');
    Route::post('/{appointment}/reject', [AdminAppointmentController::class, 'reject'])->name('reject');
    Route::post('/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('complete');
    Route::post('/{appointment}/cancel', [AdminAppointmentController::class, 'cancel'])->name('cancel');
});