<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;


Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index']);

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');

   
    Route::post('/attendance/start', [AttendanceController::class, 'start'])->name('attendance.start');

   
    Route::post('/attendance/end', [AttendanceController::class, 'end'])->name('attendance.end');

    
    Route::post('/attendance/recordRest', [AttendanceController::class, 'recordRest'])->name('attendance.recordRest');
});
