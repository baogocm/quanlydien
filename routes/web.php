<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthNhanVien;
use App\Http\Middleware\RedirectIfAuthenticated;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware([AuthNhanVien::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Khách hàng routes
    Route::get('/khachhang', [DashboardController::class, 'khachHang'])->name('khachhang.index');

    // Điện kế routes
    Route::get('/dienke', [DashboardController::class, 'dienKe'])->name('dienke.index');

    // Hóa đơn routes
    Route::get('/hoadon', [DashboardController::class, 'hoaDon'])->name('hoadon.index');

    // Giá điện routes
    Route::get('/giadien', [DashboardController::class, 'giaDien'])->name('giadien.index');

    // Users routes
    Route::get('/users', [DashboardController::class, 'users'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/update/{manv}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/delete/{manv}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/change-password/{manv}', [UserController::class, 'changePassword'])->name('users.changePassword');
});
