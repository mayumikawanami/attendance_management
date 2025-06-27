<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\StaffListController;
use App\Http\Controllers\AttendanceSheetController;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

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





    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/record', [AttendanceController::class, 'record']);
    Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance');

    Route::get('/staff', [StaffListController::class, 'index'])->name('staff.index');

    Route::get('/attendance-sheet/{id}', [AttendanceSheetController::class, 'index'])->name('attendance.sheet');
    Route::get('/attendance-sheet/index', [AttendanceSheetController::class, 'index'])->name('attendance.index');




    // 認証関連のルート
    Route::middleware(['auth'])->group(function () {
    // ログアウトルート
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});



Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create']);
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
// '/' にリダイレクトするためのルートを追加
Route::redirect('/home', '/');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Auth::routes();

// Route::get('/auth/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('auth.verify');

// // Eメールの再送信ルートを手動で定義
// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware(['auth', 'verified'])->name('verification.notice
// ');

// Route::get('/email/verify/resend', function (Request $request) {
//     $user = $request->user();
//     if ($user->hasVerifiedEmail()) {
//         return redirect()->route('auth.verify')->with('verified', true);
//     }

//     $user->sendEmailVerificationNotification();

//     return back()->with('resent', true);
// })->middleware(['auth', 'throttle:6,1'])->name('auth.resend');