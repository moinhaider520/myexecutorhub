<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\SettingController as CustomerSettingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Customer\BankAccountController;
use App\Http\Controllers\Customer\InvestmentAccountController;
use App\Http\Controllers\Customer\RealEstateController;
use App\Http\Controllers\Customer\PersonalPropertyController;
use App\Http\Controllers\Customer\BusinessInterestController;
use App\Http\Controllers\Customer\InsurancePolicyController;
use App\Http\Controllers\Customer\DebtAndLiabilitiesController;
use App\Http\Controllers\Customer\DigitalAssetsController;
use App\Http\Controllers\Customer\IntellectualPropertyController;
use App\Http\Controllers\Customer\OtherAssetsController;
use App\Http\Controllers\Customer\DocumentsController;
use App\Http\Controllers\Customer\WishesController;
use App\Http\Controllers\Customer\LifeRememberedController;
use App\Http\Controllers\Customer\AdvisorsController;
use App\Http\Controllers\Customer\ExecutorsController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Auth::routes();


Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->hasRole('executor')) {
        return redirect()->route('executor.dashboard');
    } elseif (Auth::user()->hasRole('customer')) {
        return redirect()->route('customer.dashboard');
    }
})->name('dashboard');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Profile
    Route::get('/edit-profile', [SettingController::class, 'editProfile'])->name('edit_profile');
    Route::post('/update-profile', [SettingController::class, 'updateProfile'])->name('update_profile');
    Route::post('/update-profile-image', [SettingController::class, 'updateProfileImage'])->name('update_profile_image');
    Route::post('/update-password', [SettingController::class, 'updatePassword'])->name('update_password');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Customer Profile Profile
    Route::get('/edit-profile', [CustomerSettingController::class, 'editProfile'])->name('edit_profile');
    Route::post('/update-profile', [CustomerSettingController::class, 'updateProfile'])->name('update_profile');
    Route::post('/update-profile-image', [CustomerSettingController::class, 'updateProfileImage'])->name('update_profile_image');
    Route::post('/update-password', [CustomerSettingController::class, 'updatePassword'])->name('update_password');

    // Customer Bank
    Route::get('/bank_accounts', [BankAccountController::class, 'index'])->name('bank_accounts');
    // Customer Savings
    Route::get('/investment_accounts', [InvestmentAccountController::class, 'index'])->name('investment_accounts');
    // Customer Investments
    Route::get('/real_estate', [RealEstateController::class, 'index'])->name('real_estate');
    // Customer Properties
    Route::get('/personal_property', [PersonalPropertyController::class, 'index'])->name('personal_property');
    // Customer Business interests
    Route::get('/business_interest', [BusinessInterestController::class, 'index'])->name('business_interest');
    // Customer Insurance Policies
    Route::get('/insurance_policies', [InsurancePolicyController::class, 'index'])->name('insurance_policies');
    // Customer Debt & Liabilities
    Route::get('/debt_and_liabilities', [DebtAndLiabilitiesController::class, 'index'])->name('debt_and_liabilities');
    // Customer Digital Assets
    Route::get('/digital_assets', [DigitalAssetsController::class, 'index'])->name('digital_assets');
    // Customer Intellectual Property
    Route::get('/intellectual_properties', [IntellectualPropertyController::class, 'index'])->name('intellectual_properties');
    // Customer Other Assets
    Route::get('/other_assets', [OtherAssetsController::class, 'index'])->name('other_assets');
    // Customer Documents
    Route::get('/documents', [DocumentsController::class, 'index'])->name('documents');
    // Customer Wishes
    Route::get('/wishes', [WishesController::class, 'index'])->name('wishes');
    // Customer Life Remembered
    Route::get('/life_remembered', [LifeRememberedController::class, 'index'])->name('life_remembered');
    // Customer Advisors
    Route::get('/advisors', [AdvisorsController::class, 'index'])->name('advisors');
    // Customer Executors
    Route::get('/executors', [ExecutorsController::class, 'index'])->name('executors');
});

Route::middleware(['auth', 'role:executor'])->prefix('executor')->name('executor.')->group(function () {
});
