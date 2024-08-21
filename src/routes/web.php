<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 認証されていない状態でアクセスするとログイン画面にリダイレクトされる
Route::middleware('auth')->group(function() {
/* 打刻ページ */
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/', [AttendanceController::class, 'store']);
    Route::patch('/', [AttendanceController::class, 'update']);
    Route::post('/break', [RestController::class, 'store']);
    Route::patch('/break', [RestController::class, 'update']);

    /* 日付別勤怠ページ */
    Route::get('/attendance', [AttendanceController::class, 'show']);
});

