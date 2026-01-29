<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - GeoScan Attendance
|--------------------------------------------------------------------------
*/

// --- AUTHENTICATION ---
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PINTU UTAMA (DASHBOARD) ---
// Route ini otomatis membagi user ke dashboard Admin, Headmaster, atau Teacher
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// --- GRUP ADMIN ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Kelola Ruangan
    Route::get('/rooms', [AdminController::class, 'roomIndex'])->name('admin.rooms.index');
    Route::post('/rooms/store', [AdminController::class, 'roomStore'])->name('admin.rooms.store');

    // Kelola Guru (Teachers)
    Route::get('/teachers', [AdminController::class, 'teacherIndex'])->name('admin.teachers.index');
    Route::post('/teachers/store', [AdminController::class, 'teacherStore'])->name('admin.teachers.store');

    // Laporan Gaji
    Route::get('/payroll', [AdminController::class, 'payrollIndex'])->name('admin.payroll.index');
});

// --- GRUP TEACHERS (GURU) ---
Route::middleware(['auth'])->prefix('teacher')->group(function () {
    Route::get('/scan', function () { 
        return view('teacher.scan'); 
    })->name('teacher.scan');

    Route::get('/history', [AttendanceController::class, 'history'])->name('teacher.history');
    Route::get('/payroll', [AttendanceController::class, 'paySlip'])->name('teacher.payroll');
});

// --- PROSES ABSENSI ---
// URL ini dipanggil oleh JavaScript saat guru berhasil scan QR
Route::post('/attendance/store', [AttendanceController::class, 'store'])->middleware('auth')->name('attendance.store');