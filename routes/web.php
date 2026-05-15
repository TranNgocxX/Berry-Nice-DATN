<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Nhóm các route liên quan đến dịch vụ
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    // Tìm kiếm dịch vụ
    //Route::get('/search', [ServiceController::class, 'search'])->name('services.search');
    // Danh sách theo loại (Category)
    Route::get('/category/{id}', [ServiceController::class, 'byCategory'])->name('services.category');
    
    // Chi tiết dịch vụ
    Route::get('/{id}', [ServiceController::class, 'show'])->name('services.show');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| USER LOGIN REQUIRED
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
// Profile chung cho cả Admin & User (điều hướng bên trong controller)
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/my-profile', [ProfileController::class, 'userProfile'])
        ->name('user.profile');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/appointment', [AppointmentController::class, 'create'])
        ->name('appointment.create');

    Route::post('/appointment', [AppointmentController::class, 'store'])
        ->name('appointment.store');

    Route::get('/my-appointments', [AppointmentController::class, 'index'])
        ->name('appointments.index');
        
    Route::get('/my-appointments/{id}', [AppointmentController::class, 'show'])
    ->name('appointments.show');

    Route::get('/appointments/get-slots', [AppointmentController::class, 'getSlots'])
     ->name('appointments.getSlots');

    Route::get('/appointments/{id}/success', [AppointmentController::class, 'success'])
    ->name('appointments.success');
});

