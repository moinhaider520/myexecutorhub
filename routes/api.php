<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;

// Admin
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;

// Partner
use App\Http\Controllers\Api\Partner\ProfileController as PartnerProfileController;
use App\Http\Controllers\Api\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Api\Partner\GuidanceController as PartnerGuidanceController;
use App\Http\Controllers\Api\Partner\WishesController as PartnerWishesController;
use App\Http\Controllers\Api\Partner\LifeRememberedController as PartnerLifeRememberedController;
use App\Http\Controllers\Api\Partner\VoiceNotesController as PartnerVoiceNotesController;
use App\Http\Controllers\Api\Partner\OrgansDonationController as PartnerOrgansDonationController;

// Customer 
use App\Http\Controllers\Api\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Api\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Api\Customer\GuidanceController as CustomerGuidanceController;
use App\Http\Controllers\Api\Customer\WishesController as CustomerWishesController;
use App\Http\Controllers\Api\Customer\LifeRememberedController as CustomerLifeRememberedController;
use App\Http\Controllers\Api\Customer\VoiceNotesController as CustomerVoiceNotesController;
use App\Http\Controllers\Api\Customer\OrgansDonationController as CustomerOrgansDonationController;

// Executor 
use App\Http\Controllers\Api\Executor\ProfileController as ExecutorProfileController;
use App\Http\Controllers\Api\Executor\DashboardController as ExecutorDashboardController;
use App\Http\Controllers\Api\Executor\GuidanceController as ExecutorGuidanceController;
use App\Http\Controllers\Api\Executor\WishesController as ExecutorWishesController;
use App\Http\Controllers\Api\Executor\LifeRememberedController as ExecutorLifeRememberedController;
use App\Http\Controllers\Api\Executor\VoiceNotesController as ExecutorVoiceNotesController;
use App\Http\Controllers\Api\Executor\OrgansDonationController as ExecutorOrgansDonationController;

use App\Http\Controllers\Api\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/send_reset_password_email', [ForgetPasswordController::class, 'send_reset_password_email']);

// Routes for user profile (available for all authenticated users)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update/{id}', [ProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture/{id}', [ProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/password/update/{id}', [ProfileController::class, 'update_password'])->name('profile.password.update');
});

// Admin-specific routes (requires admin role)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [AdminProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [AdminProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [AdminProfileController::class, 'update_password'])->name('profile.update.password');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Partner-specific routes
Route::middleware(['auth:sanctum', 'role:partner'])->prefix('partner')->group(function () {
    Route::get('/profile', [PartnerProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [PartnerProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [PartnerProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [PartnerProfileController::class, 'update_password'])->name('profile.update.password');

    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/guidance', [PartnerGuidanceController::class, 'view'])->name('guidance.view');
    Route::post('/guidance/update', [PartnerGuidanceController::class, 'update'])->name('guidance.update');

    Route::get('/wishes', [PartnerWishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/update', [PartnerWishesController::class, 'update'])->name('wishes.update');

    Route::get('/life-remembered', [PartnerLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::post('/life-remembered', [PartnerLifeRememberedController::class, 'update'])->name('life_remembered.update');

    Route::get('/voice-notes', [PartnerVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::post('/voice-notes', [PartnerVoiceNotesController::class, 'store'])->name('voice_notes.store');
    Route::delete('/voice-notes/{id}', [PartnerVoiceNotesController::class, 'destroy'])->name('voice_notes.destroy');

    Route::get('/organs-donations', [PartnerOrgansDonationController::class, 'view'])->name('organs_donations.view');
    Route::post('/organs-donations', [PartnerOrgansDonationController::class, 'store'])->name('organs_donations.store');
    Route::put('/organs-donations/{id}', [PartnerOrgansDonationController::class, 'update'])->name('organs_donations.update');
    Route::delete('/organs-donations/{id}', [PartnerOrgansDonationController::class, 'destroy'])->name('organs_donations.destroy');
});

// Customer-specific routes
Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/profile', [CustomerProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [CustomerProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [CustomerProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [CustomerProfileController::class, 'update_password'])->name('profile.update.password');
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/guidance', [CustomerGuidanceController::class, 'view'])->name('guidance.view');
    Route::post('/guidance/update', [CustomerGuidanceController::class, 'update'])->name('guidance.update');

    Route::get('/wishes', [CustomerWishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/update', [CustomerWishesController::class, 'update'])->name('wishes.update');

    Route::get('/life-remembered', [CustomerLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::post('/life-remembered', [CustomerLifeRememberedController::class, 'update'])->name('life_remembered.update');

    Route::get('/voice-notes', [CustomerVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::post('/voice-notes', [CustomerVoiceNotesController::class, 'store'])->name('voice_notes.store');
    Route::delete('/voice-notes/{id}', [CustomerVoiceNotesController::class, 'destroy'])->name('voice_notes.destroy');

    Route::get('/organs-donations', [CustomerOrgansDonationController::class, 'view'])->name('organs_donations.view');
    Route::post('/organs-donations', [CustomerOrgansDonationController::class, 'store'])->name('organs_donations.store');
    Route::put('/organs-donations/{id}', [CustomerOrgansDonationController::class, 'update'])->name('organs_donations.update');
    Route::delete('/organs-donations/{id}', [CustomerOrgansDonationController::class, 'destroy'])->name('organs_donations.destroy');
});

// Executor-specific routes
Route::middleware(['auth:sanctum', 'role:executor'])->prefix('executor')->group(function () {
    Route::get('/profile', [ExecutorProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [ExecutorProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [ExecutorProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [ExecutorProfileController::class, 'update_password'])->name('profile.update.password');

    Route::get('/guidance', [ExecutorGuidanceController::class, 'view'])->name('guidance.view');

    Route::get('/wishes', [ExecutorWishesController::class, 'view'])->name('wishes.view');

    Route::get('/life-remembered', [ExecutorLifeRememberedController::class, 'view'])->name('life_remembered.view');

    Route::get('/voice-notes', [ExecutorVoiceNotesController::class, 'view'])->name('voice_notes.view');

    Route::get('/organs-donations', [ExecutorOrgansDonationController::class, 'view'])->name('organs_donations.view');
});