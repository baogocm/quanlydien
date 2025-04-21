<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DienKeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BacGiaController;
use App\Http\Controllers\HoaDonController;
use App\Http\Middleware\AuthNhanVien;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\GiaDienController;
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
    Route::post('/khachhang', [GuestController::class, 'store'])->name('khachhang.store');
    Route::post('/khachhang/update/{makh}', [GuestController::class, 'update'])->name('khachhang.update');
    Route::post('/khachhang/delete/{makh}', [GuestController::class, 'destroy'])->name('khachhang.destroy');
    // Điện kế routes
    Route::get('/dienke', [DashboardController::class, 'dienKe'])->name('dienke.index');
    Route::post('/dienke', [DienKeController::class, 'store'])->name('dienke.store');
    Route::post('/dienke/update/{madk}', [DienKeController::class, 'update'])->name('dienke.update');
    Route::post('/dienke/updateTrangThai/{madk}', [DienKeController::class, 'updateTrangThai'])->name('dienke.updateTrangThai');
    Route::post('/dienke/delete/{madk}', [DienKeController::class, 'destroy'])->name('dienke.destroy');
    Route::get('/dienke/taohoadon/{madk}', [DienKeController::class, 'taoHoaDon'])->name('dienke.taohoadon');

    // Hóa đơn routes
    Route::get('/hoadon', [DashboardController::class, 'hoaDon'])->name('hoadon.index');
    Route::post('/hoadon/update-status/{mahd}', [HoaDonController::class, 'updateStatus'])->name('hoadon.updateStatus');

    // Routes cho quản lý giá điện
    Route::get('/giadien/history', [GiaDienController::class, 'history'])->name('giadien.history');
    Route::get('/giadien/history/{id}', [GiaDienController::class, 'historyDetail'])->name('giadien.history.detail');
    Route::get('/giadien', [GiaDienController::class, 'index'])->name('giadien.index');
    Route::post('/giadien', [GiaDienController::class, 'store'])->name('giadien.store');
    Route::post('/giadien/{id}', [GiaDienController::class, 'destroy'])->name('giadien.destroy');
    Route::post('/giadien/update/{id}', [GiaDienController::class, 'update'])->name('giadien.update');

    // Users routes
    Route::get('/users', [DashboardController::class, 'users'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/update/{manv}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/delete/{manv}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/change-password/{manv}', [UserController::class, 'changePassword'])->name('users.changePassword');
});

