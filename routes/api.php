<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[RegisterController::class,'register']);
Route::post('/send_reset_password_email',[ForgetPasswordController::class,'send_reset_password_email']);
