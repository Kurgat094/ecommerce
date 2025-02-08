<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/',[AuthController::class,'register'])->name('register');
Route::post('/registerpost',[AuthController::class,'registerPost'])->name('registerPost');
Route::get('/otp',[AuthController::class,'otp'])->name('otp');
Route::post('/verifyOtp',[AuthController::class,'verifyOtp'])->name('verifyOtp');
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/loginpost',[AuthController::class,'loginpost'])->name('loginpost');
Route::get('/forgotpassword',[AuthController::class,'forgotpassword'])->name('forgotpassword');
Route::get('/setnewpassword/{token}',[AuthController::class,'setnewpassword'])->name('setnewpassword');
Route::post('/forgotpasswordpost',[AuthController::class,'forgotpasswordpost'])->name('forgotpasswordpost');
Route::post('/resetpasswordpost/{token}',[AuthController::class,'resetpasswordpost'])->name('resetpasswordpost');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

//customer
Route::get('/dashboard/',[CustomerController::class,'dashboard'])->name('dashboard');
