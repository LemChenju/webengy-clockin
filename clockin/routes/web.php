<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login',[AuthController::class, 'postLogin'])->name('login.post');
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/settings',[AuthController::class, 'settings'])->name('settings');
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/password/change', [ProfileController::class, 'showPasswordChangeForm'])->name('password.change');
Route::post('/password/change', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::post('/profile/image', [ProfileController::class, 'updateProfileImage'])->name('profile.image.update');
Route::get('/settings', [ProfileController::class, 'showSettings'])->name('settings');
Route::post('/clockinout',[ProfileController::class, 'clockinout'])->name('clockinout');
Route::get('/clockinout',[ProfileController::class, 'clockinout'])->name('clockinout');
