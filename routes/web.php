<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\User\ChatboxController;
use App\Http\Controllers\User\AppointmentController as AppointmentController;

// PUBLIC - Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::post('/chatbot-tu-van/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

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

    Route::get('/appointments/slots', [AppointmentController::class, 'getSlots'])
        ->name('appointments.getSlots');

    Route::get('/appointments/{id}/success', [AppointmentController::class, 'success'])
        ->name('appointments.success');
});
