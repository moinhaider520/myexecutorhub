<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ADMIN
Route::get('/customers', function () {
    return view('admin/customers/view');
})->name('customers');

Route::get('/edit_profile', function () {
    return view('admin/account_settings/edit_profile');
})->name('edit_profile');


// Customer
Route::get('/dashboard_customer', function () {
    return view('customer/dashboard/home');
})->name('dashboard_customer');