<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\UserController;

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
Route::middleware('auth', 'verified')->group(function() {
    /* 打刻ページ */
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/', [AttendanceController::class, 'store']);
    Route::patch('/', [AttendanceController::class, 'update']);
    Route::post('/rest', [RestController::class, 'store']);
    Route::patch('/rest', [RestController::class, 'update']);

    /* 日付別勤怠ページ */
    Route::get('/attendance', [AttendanceController::class, 'show']);

    /* ユーザー一覧ページ */
    Route::get('/user', [UserController::class, 'index']);
    /* ユーザー詳細ページ */
    Route::get('/user/detail', [UserController::class, 'show']);
});

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メール確認通知再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'ご登録のメールアドレス宛に再送信しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
