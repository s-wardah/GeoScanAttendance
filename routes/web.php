<?php

use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Headmaster\ReportController;

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
    Route::put('/rooms/{id}', [AdminController::class, 'roomUpdate'])->name('admin.rooms.update');
    Route::delete('/rooms/{id}', [AdminController::class, 'roomDestroy'])->name('admin.rooms.destroy');
    Route::get('/rooms/print/{id}', [AdminController::class, 'roomPrint'])->name('admin.rooms.print');

    // Kelola Guru (Teachers)
    Route::get('/teachers', [AdminController::class, 'teacherIndex'])->name('admin.teachers.index');
    Route::post('/teachers/store', [AdminController::class, 'teacherStore'])->name('admin.teachers.store');

    // Laporan Gaji
    Route::get('/payroll', [AdminController::class, 'payrollIndex'])->name('admin.payroll.index');

    // Kelola Jadwal
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('admin.schedule.index');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('admin.schedule.store');
});

// --- GRUP TEACHERS (GURU) ---
Route::middleware(['auth'])->prefix('teacher')->group(function () {
    Route::get('/scan', function () {
        return view('teacher.scan');
    })->name('teacher.scan');

    Route::get('/history', [AttendanceController::class, 'history'])->name('teacher.history');
    Route::get('/payroll', [AttendanceController::class, 'paySlip'])->name('teacher.payroll');

    Route::get('/permission', [App\Http\Controllers\Teacher\DashboardController::class, 'indexPermission'])->name('teacher.permission.index');
    Route::get('/permission/create', [App\Http\Controllers\Teacher\DashboardController::class, 'createPermission'])->name('teacher.permission.create');
    Route::post('/permission/store', [App\Http\Controllers\Teacher\DashboardController::class, 'storePermission'])->name('teacher.permission.store');
});

Route::middleware(['auth'])->prefix('headmaster')->name('headmaster.')->group(function () {
    Route::get('/reports', [App\Http\Controllers\Headmaster\ReportController::class, 'index'])->name('reports.index');

    Route::get('/permissions', [App\Http\Controllers\Headmaster\ReportController::class, 'listPermissions'])->name('permissions.index');
    Route::post('/permissions/{id}/update', [App\Http\Controllers\Headmaster\ReportController::class, 'updatePermissionStatus'])->name('permissions.update');

    Route::get('/reports/pdf', [ReportController::class, 'exportPDF'])->name('reports.pdf');
});

// --- PROSES ABSENSI ---
// URL ini dipanggil oleh JavaScript saat guru berhasil scan QR
Route::post('/attendance/store', [AttendanceController::class, 'store'])->middleware('auth')->name('attendance.store');
