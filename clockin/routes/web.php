<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\StampController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/loginAction',[AuthController::class, 'loginAction'])->name('login.action');
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/registrationAction', [AuthController::class, 'registrationAction'])->name('register.action');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/password/change', [ProfileController::class, 'showPasswordChangeForm'])->name('password.change');
Route::post('/password/change', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::post('/profile/image', [ProfileController::class, 'updateProfileImage'])->name('profile.image.update');
Route::get('/settings', [ProfileController::class, 'showSettings'])->name('settings');
Route::get('/clockinout',[ProfileController::class, 'clockinout'])->name('clockinout');
Route::get('/history',[ProfileController::class, 'history'])->name('history');
Route::get('/stamp-in', [StampController::class, 'stampIn'])->name('stamp-in');
Route::get('/stamp-out', [StampController::class, 'stampOut'])->name('stamp-out');
Route::post('/generatePDF', [HistoryController::class, 'generatePDF'])->name('generate-pdf');
