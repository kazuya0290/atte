<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;

// 認証関連のルート
Auth::routes();

// ホーム画面のルート
Route::get('/', [HomeController::class, 'index'])->name('home');

// 勤怠管理のルート定義
// 認証が必要なルートに 'auth' ミドルウェアを適用
Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index']);

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');

    // 勤務開始ボタンのルート
    Route::post('/attendance/start', [AttendanceController::class, 'start'])->name('attendance.start');

    // 勤務終了ボタンのルート
    Route::post('/attendance/end', [AttendanceController::class, 'end'])->name('attendance.end');

    // 休憩記録ボタンのルート
    Route::post('/attendance/recordRest', [AttendanceController::class, 'recordRest'])->name('attendance.recordRest');
});
