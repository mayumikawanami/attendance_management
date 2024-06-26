<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\StaffListController;
use App\Http\Controllers\AttendanceSheetController;

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
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);


