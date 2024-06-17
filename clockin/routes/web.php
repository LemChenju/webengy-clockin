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
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/settings',[AuthController::class, 'settings'])->name('settings');
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
Route::get('/password/change', [ProfileController::class, 'showPasswordChangeForm'])->name('password.change');
Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
