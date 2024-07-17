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
use App\Http\Controllers\Customer\PersonalChattelController;
use App\Http\Controllers\Customer\BusinessInterestController;
use App\Http\Controllers\Customer\InsurancePolicyController;
use App\Http\Controllers\Customer\DebtAndLiabilityController;
use App\Http\Controllers\Customer\DigitalAssetController;
use App\Http\Controllers\Customer\IntellectualPropertyController;
use App\Http\Controllers\Customer\OtherAssetController;
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

    // Customer Profile 
    Route::get('/edit-profile', [CustomerSettingController::class, 'editProfile'])->name('edit_profile');
    Route::post('/update-profile', [CustomerSettingController::class, 'updateProfile'])->name('update_profile');
    Route::post('/update-profile-image', [CustomerSettingController::class, 'updateProfileImage'])->name('update_profile_image');
    Route::post('/update-password', [CustomerSettingController::class, 'updatePassword'])->name('update_password');

    // Customer Life Remembered
    Route::get('/life_remembered/view', [LifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::post('/life_remembered/update', [LifeRememberedController::class, 'update'])->name('life_remembered.update');

    // Customer Wishes
    Route::get('/wishes/view', [WishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/update', [WishesController::class, 'update'])->name('wishes.update');

    // Customer Documents
    Route::get('/documents/view', [DocumentsController::class, 'view'])->name('documents.view');
    Route::post('/documents/store', [DocumentsController::class, 'store'])->name('documents.store');
    Route::post('/documents/update/{id}', [DocumentsController::class, 'update'])->name('documents.update');
    Route::delete('/documents/destroy/{id}', [DocumentsController::class, 'destroy'])->name('documents.destroy');

    // Customer Advisors
    Route::get('/advisors/view', [AdvisorsController::class, 'view'])->name('advisors.view');
    Route::post('/advisors/store', [AdvisorsController::class, 'store'])->name('advisors.store');
    Route::post('/advisors/update/{id}', [AdvisorsController::class, 'update'])->name('advisors.update');
    Route::delete('/advisors/destroy/{id}', [AdvisorsController::class, 'destroy'])->name('advisors.destroy');

    // Customer Executors
    Route::get('/executors/view', [ExecutorsController::class, 'view'])->name('executors.view');
    Route::post('/executors/store', [ExecutorsController::class, 'store'])->name('executors.store');
    Route::post('/executors/update/{id}', [ExecutorsController::class, 'update'])->name('executors.update');
    Route::delete('/executors/destroy/{id}', [ExecutorsController::class, 'destroy'])->name('executors.destroy');

    // Customer Bank
    Route::get('/bank_accounts/view', [BankAccountController::class, 'view'])->name('bank_accounts.view');
    Route::post('/bank_accounts/store', [BankAccountController::class, 'store'])->name('bank_accounts.store');
    Route::post('/bank_accounts/update/{id}', [BankAccountController::class, 'update'])->name('bank_accounts.update');
    Route::delete('/bank_accounts/destroy/{id}', [BankAccountController::class, 'destroy'])->name('bank_accounts.destroy');

    // Customer Savings
    Route::get('/investment_accounts/view', [InvestmentAccountController::class, 'index'])->name('investment_accounts.view');
    Route::post('/investment_accounts/store', [InvestmentAccountController::class, 'store'])->name('investment_accounts.store');
    Route::post('/investment_accounts/update/{id}', [InvestmentAccountController::class, 'update'])->name('investment_accounts.update');
    Route::delete('/investment_accounts/destroy/{id}', [InvestmentAccountController::class, 'destroy'])->name('investment_accounts.destroy');

    // Customer Real Estate
    Route::get('/real_estate', [RealEstateController::class, 'index'])->name('real_estate');

    // Customer Chattels
    Route::get('/personal_chattels/view', [PersonalChattelController::class, 'view'])->name('personal_chattels.view');
    Route::post('/personal_chattels/store', [PersonalChattelController::class, 'store'])->name('personal_chattels.store');
    Route::post('/personal_chattels/update/{id}', [PersonalChattelController::class, 'update'])->name('personal_chattels.update');
    Route::delete('/personal_chattels/destroy/{id}', [PersonalChattelController::class, 'destroy'])->name('personal_chattels.destroy');

    // Customer Business interests
    Route::get('/business_interests/view', [BusinessInterestController::class, 'view'])->name('business_interests.view');
    Route::post('/business_interests/store', [BusinessInterestController::class, 'store'])->name('business_interests.store');
    Route::post('/business_interests/update/{id}', [BusinessInterestController::class, 'update'])->name('business_interests.update');
    Route::delete('/business_interests/destroy/{id}', [BusinessInterestController::class, 'destroy'])->name('business_interests.destroy');

    // Customer Insurance Policies
    Route::get('/insurance_policies/view', [InsurancePolicyController::class, 'view'])->name('insurance_policies.view');
    Route::post('/insurance_policies/store', [InsurancePolicyController::class, 'store'])->name('insurance_policies.store');
    Route::post('/insurance_policies/update/{id}', [InsurancePolicyController::class, 'update'])->name('insurance_policies.update');
    Route::delete('/insurance_policies/destroy/{id}', [InsurancePolicyController::class, 'destroy'])->name('insurance_policies.destroy');

    // Customer Debt & Liability
    Route::get('/debt_and_liabilities/view', [DebtAndLiabilityController::class, 'view'])->name('debt_and_liabilities.view');
    Route::post('/debt_and_liabilities/store', [DebtAndLiabilityController::class, 'store'])->name('debt_and_liabilities.store');
    Route::post('/debt_and_liabilities/update/{id}', [DebtAndLiabilityController::class, 'update'])->name('debt_and_liabilities.update');
    Route::delete('/debt_and_liabilities/destroy/{id}', [DebtAndLiabilityController::class, 'destroy'])->name('debt_and_liabilities.destroy');

    // Customer Digital Assets
    Route::get('/digital_assets/view', [DigitalAssetController::class, 'view'])->name('digital_assets.view');
    Route::post('/digital_assets/store', [DigitalAssetController::class, 'store'])->name('digital_assets.store');
    Route::post('/digital_assets/update/{id}', [DigitalAssetController::class, 'update'])->name('digital_assets.update');
    Route::delete('/digital_assets/destroy/{id}', [DigitalAssetController::class, 'destroy'])->name('digital_assets.destroy');

    // Customer Intellectual Property
    Route::get('/intellectual_properties/view', [IntellectualPropertyController::class, 'view'])->name('intellectual_properties.view');
    Route::post('/intellectual_properties/store', [IntellectualPropertyController::class, 'store'])->name('intellectual_properties.store');
    Route::post('/intellectual_properties/update/{id}', [IntellectualPropertyController::class, 'update'])->name('intellectual_properties.update');
    Route::delete('/intellectual_properties/destroy/{id}', [IntellectualPropertyController::class, 'destroy'])->name('intellectual_properties.destroy');

    // Customer Other Assets
    Route::get('/other_assets/view', [OtherAssetController::class, 'view'])->name('other_assets.view');
    Route::post('/other_assets/store', [OtherAssetController::class, 'store'])->name('other_assets.store');
    Route::post('/other_assets/update/{id}', [OtherAssetController::class, 'update'])->name('other_assets.update');
    Route::delete('/other_assets/destroy/{id}', [OtherAssetController::class, 'destroy'])->name('other_assets.destroy');
});

Route::middleware(['auth', 'role:executor'])->prefix('executor')->name('executor.')->group(function () {
});
