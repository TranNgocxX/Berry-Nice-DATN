<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\BookingController as BookingController;

// PUBLIC - Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// Danh sách theo danh mục (Category)
Route::get('/category/{category}', [ServiceController::class, 'byCategory'])->name('services.category');

// Nhóm các route liên quan đến dịch vụ
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    // Chi tiết dịch vụ
    Route::get('/{service}', [ServiceController::class, 'show'])->name('services.show');
});

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// LOGIN REQUIRED
Route::middleware('auth')->group(function () {
    // Profile chung cho cả Admin & User (điều hướng bên trong controller)
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::get('/my-profile', [ProfileController::class, 'userProfile'])
        ->name('user.profile.index');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');
    
    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::get('/bookings/create', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings/slots', [BookingController::class, 'getSlots'])
        ->name('bookings.getSlots');

    Route::get('/bookings/{id}', [BookingController::class, 'show'])
        ->name('bookings.show');

    Route::get('/bookings/{id}/success', [BookingController::class, 'success'])
        ->name('bookings.success');
});
