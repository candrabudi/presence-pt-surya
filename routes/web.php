<?php

use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminHolidayController;
use App\Http\Controllers\Admin\AdminLeaveController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSiteSettingController;
use App\Http\Controllers\Admin\AdminWorkScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employee\EmployeeAttendanceController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Employee\EmployeeLeaveController;
use App\Http\Controllers\Employee\EmployeeProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/employees', [AdminEmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [AdminEmployeeController::class, 'store'])->name('employees.store');
    Route::put('/employees/{id}', [AdminEmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [AdminEmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::get('attendance', [AdminAttendanceController::class, 'index'])->name('attendance.index');

    Route::get('/holidays', [AdminHolidayController::class, 'index'])->name('holidays.index');
    Route::post('/holidays/store', [AdminHolidayController::class, 'store'])->name('holidays.store');
    Route::post('/holidays/update/{id}', [AdminHolidayController::class, 'update'])->name('holidays.update');
    Route::delete('/holidays/destroy/{id}', [AdminHolidayController::class, 'destroy'])->name('holidays.destroy');

    Route::get('leaves', [AdminLeaveController::class, 'index'])->name('leaves.index');
    Route::put('leaves/{id}', [AdminLeaveController::class, 'update'])->name('leaves.update');

    Route::get('work-schedules', [AdminWorkScheduleController::class, 'index'])->name('work-schedules.index');

    Route::put('work-schedules/{id}', [AdminWorkScheduleController::class, 'update'])->name('work-schedules.update');

    Route::get('/site-settings', [AdminSiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('/site-settings', [AdminSiteSettingController::class, 'update'])->name('site-settings.update');

    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

});

Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/attendance', [EmployeeAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/checkin', [EmployeeAttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [EmployeeAttendanceController::class, 'checkOut'])->name('attendance.checkout');

    Route::get('/profile', [EmployeeProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [EmployeeProfileController::class, 'update'])->name('profile.update');

    Route::get('/attendance/check', [EmployeeAttendanceController::class, 'showForm'])->name('attendance.form');
    Route::post('/attendance/checkin', [EmployeeAttendanceController::class, 'checkin'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [EmployeeAttendanceController::class, 'checkout'])->name('attendance.checkout');
    Route::get('/attendance/success', fn () => view('_employee.attendance.page-success'))->name('attendance.success');

    Route::get('/leave', [EmployeeLeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/request', [EmployeeLeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave/request', [EmployeeLeaveController::class, 'store'])->name('leave.store');
});