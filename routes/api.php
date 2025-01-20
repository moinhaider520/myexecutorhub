<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;

// Admin
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\WithdrawalController as AdminWithdrawalController;

// Partner
use App\Http\Controllers\Api\Partner\ProfileController as PartnerProfileController;
use App\Http\Controllers\Api\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Api\Partner\GuidanceController as PartnerGuidanceController;
use App\Http\Controllers\Api\Partner\WishesController as PartnerWishesController;
use App\Http\Controllers\Api\Partner\LifeRememberedController as PartnerLifeRememberedController;
use App\Http\Controllers\Api\Partner\VoiceNotesController as PartnerVoiceNotesController;
use App\Http\Controllers\Api\Partner\OrgansDonationController as PartnerOrgansDonationController;
use App\Http\Controllers\Api\Partner\BankAccountController as PartnerBankAccountController;
use App\Http\Controllers\Api\Partner\InvestmentAccountController as PartnerInvestmentAccountController;
use App\Http\Controllers\Api\Partner\PropertyController as PartnerPropertyController;
use App\Http\Controllers\Api\Partner\PersonalChattelController as PartnerPersonalChattelController;
use App\Http\Controllers\Api\Partner\AdvisorsController as PartnerAdvisorsController;
use App\Http\Controllers\Api\Partner\ExecutorsController as PartnerExecutorsController;
use App\Http\Controllers\Api\Partner\DocumentsController as PartnerDocumentsController;
use App\Http\Controllers\Api\Partner\BusinessInterestController as PartnerBusinessInterestController;
use App\Http\Controllers\Api\Partner\InsurancePolicyController as PartnerInsurancePolicyController;
use App\Http\Controllers\Api\Partner\DebtAndLiabilityController as PartnerDebtAndLiabilityController;
use App\Http\Controllers\Api\Partner\DigitalAssetController as PartnerDigitalAssetController;
use App\Http\Controllers\Api\Partner\IntellectualPropertyController as PartnerIntellectualPropertyController;
use App\Http\Controllers\Api\Partner\OtherAssetController as PartnerOtherAssetController;
use App\Http\Controllers\Api\Partner\ReviewController as PartnerReviewController;
use App\Http\Controllers\Api\Partner\OpenAIController as PartnerOpenAIController;
use App\Http\Controllers\Api\Partner\MessageController as PartnerMessageController;
use App\Http\Controllers\Api\Partner\PermissionController as PartnerPermissionController;
use App\Http\Controllers\Api\Partner\WithdrawalController as PartnerWithdrawalController;
use App\Http\Controllers\Api\Partner\LPAController as PartnerLPAController;

// Customer 
use App\Http\Controllers\Api\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Api\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Api\Customer\GuidanceController as CustomerGuidanceController;
use App\Http\Controllers\Api\Customer\WishesController as CustomerWishesController;
use App\Http\Controllers\Api\Customer\LifeRememberedController as CustomerLifeRememberedController;
use App\Http\Controllers\Api\Customer\VoiceNotesController as CustomerVoiceNotesController;
use App\Http\Controllers\Api\Customer\OrgansDonationController as CustomerOrgansDonationController;
use App\Http\Controllers\Api\Customer\BankAccountController as CustomerBankAccountController;
use App\Http\Controllers\Api\Customer\InvestmentAccountController as CustomerInvestmentAccountController;
use App\Http\Controllers\Api\Customer\PropertyController as CustomerPropertyController;
use App\Http\Controllers\Api\Customer\PersonalChattelController as CustomerPersonalChattelController;
use App\Http\Controllers\Api\Customer\BusinessInterestController as CustomerBusinessInterestController;
use App\Http\Controllers\Api\Customer\InsurancePolicyController as CustomerInsurancePolicyController;
use App\Http\Controllers\Api\Customer\DebtAndLiabilityController as CustomerDebtAndLiabilityController;
use App\Http\Controllers\Api\Customer\DigitalAssetController as CustomerDigitalAssetController;
use App\Http\Controllers\Api\Customer\IntellectualPropertyController as CustomerIntellectualPropertyController;
use App\Http\Controllers\Api\Customer\OtherAssetController as CustomerOtherAssetController;
use App\Http\Controllers\Api\Customer\AdvisorsController as CustomerAdvisorsController;
use App\Http\Controllers\Api\Customer\ExecutorsController as CustomerExecutorsController;
use App\Http\Controllers\Api\Customer\DocumentsController as CustomerDocumentsController;
use App\Http\Controllers\Api\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Api\Customer\OpenAIController as CustomerOpenAIController;
use App\Http\Controllers\Api\Customer\MessageController as CustomerMessageController;
use App\Http\Controllers\Api\Customer\PermissionController as CustomerPermissionController;
use App\Http\Controllers\Api\Customer\WithdrawalController as CustomerWithdrawalController;
use App\Http\Controllers\Api\Customer\LPAController as CustomerLPAController;


// Executor 
use App\Http\Controllers\Api\Executor\ProfileController as ExecutorProfileController;
use App\Http\Controllers\Api\Executor\DashboardController as ExecutorDashboardController;
use App\Http\Controllers\Api\Executor\GuidanceController as ExecutorGuidanceController;
use App\Http\Controllers\Api\Executor\WishesController as ExecutorWishesController;
use App\Http\Controllers\Api\Executor\LifeRememberedController as ExecutorLifeRememberedController;
use App\Http\Controllers\Api\Executor\VoiceNotesController as ExecutorVoiceNotesController;
use App\Http\Controllers\Api\Executor\OrgansDonationController as ExecutorOrgansDonationController;
use App\Http\Controllers\Api\Executor\BankAccountController as ExecutorBankAccountController;
use App\Http\Controllers\Api\Executor\InvestmentAccountController as ExecutorInvestmentAccountController;
use App\Http\Controllers\Api\Executor\PropertyController as ExecutorPropertyController;
use App\Http\Controllers\Api\Executor\PersonalChattelController as ExecutorPersonalChattelController;
use App\Http\Controllers\Api\Executor\BusinessInterestController as ExecutorBusinessInterestController;
use App\Http\Controllers\Api\Executor\InsurancePolicyController as ExecutorInsurancePolicyController;
use App\Http\Controllers\Api\Executor\DebtAndLiabilityController as ExecutorDebtAndLiabilityController;
use App\Http\Controllers\Api\Executor\DigitalAssetController as ExecutorDigitalAssetController;
use App\Http\Controllers\Api\Executor\IntellectualPropertyController as ExecutorIntellectualPropertyController;
use App\Http\Controllers\Api\Executor\OtherAssetController as ExecutorOtherAssetController;
use App\Http\Controllers\Api\Executor\DocumentsController as ExecutorDocumentsController;
use App\Http\Controllers\Api\Executor\ReviewController as ExecutorReviewController;
use App\Http\Controllers\Api\Executor\MessageController as ExecutorMessageController;
use App\Http\Controllers\Api\Executor\OpenAIController as ExecutorOpenAIController;
use App\Http\Controllers\Api\Executor\WithdrawalController as ExecutorWithdrawalController;
use App\Http\Controllers\Api\Executor\LPAController as ExecutorLPAController;

// General Controllers
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ExpoController;

use Stripe\Customer;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('verify-two-factor', [LoginController::class, 'verifyTwoFactor']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/send_reset_password_email', [ForgetPasswordController::class, 'send_reset_password_email']);

// Route to update the expo token
Route::post('/expo/update-token/{id}', [ExpoController::class, 'updateExpoToken'])->name('expo.update-token');

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

    // Admin Withdrawal Management
    Route::get('/withdraw', [AdminWithdrawalController::class, 'index'])->name('withdraw.index');
    Route::patch('/withdraw/{id}', [AdminWithdrawalController::class, 'update'])->name('withdraw.update');
});

// Partner-specific routes
Route::middleware(['auth:sanctum', 'role:partner'])->prefix('partner')->group(function () {
    Route::get('/profile', [PartnerProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [PartnerProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [PartnerProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [PartnerProfileController::class, 'update_password'])->name('profile.update.password');
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');


    // Partner Withdraw
    Route::get('/withdraw', [PartnerWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [PartnerWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [PartnerWithdrawalController::class, 'history'])->name('withdraw.history');

    // Partner Advisors
    Route::get('/advisors/view', [PartnerAdvisorsController::class, 'view'])->name('advisors.view');
    Route::post('/advisors/store', [PartnerAdvisorsController::class, 'store'])->name('advisors.store');
    Route::post('/advisors/update/{id}', [PartnerAdvisorsController::class, 'update'])->name('advisors.update');
    Route::delete('/advisors/destroy/{id}', [PartnerAdvisorsController::class, 'destroy'])->name('advisors.destroy');

    // Partner Executors
    Route::get('/executors/view', [PartnerExecutorsController::class, 'view'])->name('executors.view');
    Route::post('/executors/store', [PartnerExecutorsController::class, 'store'])->name('executors.store');
    Route::post('/executors/update/{id}', [PartnerExecutorsController::class, 'update'])->name('executors.update');
    Route::delete('/executors/destroy/{id}', [PartnerExecutorsController::class, 'destroy'])->name('executors.destroy');

    // Custom Documents Type
    Route::post('/documents/save_custom_type', [PartnerDocumentsController::class, 'saveCustomType'])->name('documents.save_custom_type');
    // Partner Documents
    Route::get('/documents/view', [PartnerDocumentsController::class, 'view'])->name('documents.view');
    Route::post('/documents/store', [PartnerDocumentsController::class, 'store'])->name('documents.store');
    Route::post('/documents/update/{id}', [PartnerDocumentsController::class, 'update'])->name('documents.update');
    Route::delete('/documents/destroy/{id}', [PartnerDocumentsController::class, 'destroy'])->name('documents.destroy');

    // Reviews
    Route::post('reviews', [PartnerReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [PartnerReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [PartnerReviewController::class, 'destroy'])->name('reviews.destroy');

    // Partner Bank
    Route::get('/bank_accounts/view', [PartnerBankAccountController::class, 'view'])->name('bank_accounts.view');
    Route::post('/bank_accounts/store', [PartnerBankAccountController::class, 'store'])->name('bank_accounts.store');
    Route::post('/bank_accounts/update/{id}', [PartnerBankAccountController::class, 'update'])->name('bank_accounts.update');
    Route::delete('/bank_accounts/destroy/{id}', [PartnerBankAccountController::class, 'destroy'])->name('bank_accounts.destroy');

    // Custom Investment Types
    Route::post('/investment_accounts/save_custom_type', [PartnerInvestmentAccountController::class, 'saveCustomType'])->name('investment_accounts.save_custom_type');
    // Partner Savings
    Route::get('/investment_accounts/view', [PartnerInvestmentAccountController::class, 'view'])->name('investment_accounts.view');
    Route::post('/investment_accounts/store', [PartnerInvestmentAccountController::class, 'store'])->name('investment_accounts.store');
    Route::post('/investment_accounts/update/{id}', [PartnerInvestmentAccountController::class, 'update'])->name('investment_accounts.update');
    Route::delete('/investment_accounts/destroy/{id}', [PartnerInvestmentAccountController::class, 'destroy'])->name('investment_accounts.destroy');

    // Custom Property Type
    Route::post('/properties/save_custom_type', [PartnerPropertyController::class, 'saveCustomType'])->name('properties.save_custom_type');
    // Partner Property (ies) Owned
    Route::get('/properties/view', [PartnerPropertyController::class, 'view'])->name('properties.view');
    Route::post('/properties/store', [PartnerPropertyController::class, 'store'])->name('properties.store');
    Route::put('/properties/update/{id}', [PartnerPropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{id}', [PartnerPropertyController::class, 'destroy'])->name('properties.destroy');

    //Partner Custom Chattels
    Route::post('/personal_chattels/save_custom_type', [PartnerPersonalChattelController::class, 'saveCustomType'])->name('personal_chattels.save_custom_type');

    // Partner Chattels
    Route::get('/personal_chattels/view', [PartnerPersonalChattelController::class, 'view'])->name('personal_chattels.view');
    Route::post('/personal_chattels/store', [PartnerPersonalChattelController::class, 'store'])->name('personal_chattels.store');
    Route::post('/personal_chattels/update/{id}', [PartnerPersonalChattelController::class, 'update'])->name('personal_chattels.update');
    Route::delete('/personal_chattels/destroy/{id}', [PartnerPersonalChattelController::class, 'destroy'])->name('personal_chattels.destroy');

    // Custom Business Types
    Route::post('/business_interests/save_custom_type', [PartnerBusinessInterestController::class, 'saveCustomType'])->name('business_interests.save_custom_type');
    // Partner Business interests
    Route::get('/business_interests/view', [PartnerBusinessInterestController::class, 'view'])->name('business_interests.view');
    Route::post('/business_interests/store', [PartnerBusinessInterestController::class, 'store'])->name('business_interests.store');
    Route::post('/business_interests/update/{id}', [PartnerBusinessInterestController::class, 'update'])->name('business_interests.update');
    Route::delete('/business_interests/destroy/{id}', [PartnerBusinessInterestController::class, 'destroy'])->name('business_interests.destroy');

    // Custom Insurance Type
    Route::post('/insurance_policies/save_custom_type', [PartnerInsurancePolicyController::class, 'saveCustomType'])->name('insurance_policies.save_custom_type');
    // Partner Insurance Policies
    Route::get('/insurance_policies/view', [PartnerInsurancePolicyController::class, 'view'])->name('insurance_policies.view');
    Route::post('/insurance_policies/store', [PartnerInsurancePolicyController::class, 'store'])->name('insurance_policies.store');
    Route::post('/insurance_policies/update/{id}', [PartnerInsurancePolicyController::class, 'update'])->name('insurance_policies.update');
    Route::delete('/insurance_policies/destroy/{id}', [PartnerInsurancePolicyController::class, 'destroy'])->name('insurance_policies.destroy');

    // Custom Debt Type
    Route::post('/debt_and_liabilities/save_custom_type', [PartnerDebtAndLiabilityController::class, 'saveCustomType'])->name('debt_and_liabilities.save_custom_type');
    // Partner Debt & Liability
    Route::get('/debt_and_liabilities/view', [PartnerDebtAndLiabilityController::class, 'view'])->name('debt_and_liabilities.view');
    Route::post('/debt_and_liabilities/store', [PartnerDebtAndLiabilityController::class, 'store'])->name('debt_and_liabilities.store');
    Route::post('/debt_and_liabilities/update/{id}', [PartnerDebtAndLiabilityController::class, 'update'])->name('debt_and_liabilities.update');
    Route::delete('/debt_and_liabilities/destroy/{id}', [PartnerDebtAndLiabilityController::class, 'destroy'])->name('debt_and_liabilities.destroy');

    // Custom Digital Assets Type
    Route::post('/digital_assets/save_custom_type', [PartnerDigitalAssetController::class, 'saveCustomType'])->name('digital_assets.save_custom_type');
    // Partner Digital Assets
    Route::get('/digital_assets/view', [PartnerDigitalAssetController::class, 'view'])->name('digital_assets.view');
    Route::post('/digital_assets/store', [PartnerDigitalAssetController::class, 'store'])->name('digital_assets.store');
    Route::post('/digital_assets/update/{id}', [PartnerDigitalAssetController::class, 'update'])->name('digital_assets.update');
    Route::delete('/digital_assets/destroy/{id}', [PartnerDigitalAssetController::class, 'destroy'])->name('digital_assets.destroy');

    // Custom Intellectual Property Types
    Route::post('/intellectual_properties/save_custom_type', [PartnerIntellectualPropertyController::class, 'saveCustomType'])->name('intellectual_properties.save_custom_type');
    // Partner Intellectual Property
    Route::get('/intellectual_properties/view', [PartnerIntellectualPropertyController::class, 'view'])->name('intellectual_properties.view');
    Route::post('/intellectual_properties/store', [PartnerIntellectualPropertyController::class, 'store'])->name('intellectual_properties.store');
    Route::post('/intellectual_properties/update/{id}', [PartnerIntellectualPropertyController::class, 'update'])->name('intellectual_properties.update');
    Route::delete('/intellectual_properties/destroy/{id}', [PartnerIntellectualPropertyController::class, 'destroy'])->name('intellectual_properties.destroy');

    // Custom Other Asset Type
    Route::post('/other_assets/save_custom_type', [PartnerOtherAssetController::class, 'saveCustomType'])->name('other_assets.save_custom_type');
    // Partner Other Assets
    Route::get('/other_assets/view', [PartnerOtherAssetController::class, 'view'])->name('other_assets.view');
    Route::post('/other_assets/store', [PartnerOtherAssetController::class, 'store'])->name('other_assets.store');
    Route::post('/other_assets/update/{id}', [PartnerOtherAssetController::class, 'update'])->name('other_assets.update');
    Route::delete('/other_assets/destroy/{id}', [PartnerOtherAssetController::class, 'destroy'])->name('other_assets.destroy');

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

    // OPENAI
    Route::get('/openai/view', [PartnerOpenAIController::class, 'view'])->name('openai.view');
    Route::post('/openai/chat', [PartnerOpenAIController::class, 'chat'])->name('openai.chat');

    Route::post('/messages/send', [PartnerMessageController::class, 'sendMessage']);
    Route::get('/messages/{userId}', [PartnerMessageController::class, 'getMessages']);
    Route::get('/users', [PartnerMessageController::class, 'getUsers']);

    // Assign Permission 
    Route::get('/assign-permissions', [PartnerPermissionController::class, 'getRolesAndPermissions'])->name('assign_permissions_form');
    Route::post('/assign-permissions', [PartnerPermissionController::class, 'assignPermissions'])->name('assign_permissions');

    // LPAVIDEOS
    Route::get('/lpa', [PartnerLPAController::class, 'view'])->name('lpa.view');
});

// Customer-specific routes
Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/profile', [CustomerProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [CustomerProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [CustomerProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [CustomerProfileController::class, 'update_password'])->name('profile.update.password');
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Customer Withdraw
    Route::get('/withdraw', [CustomerWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [CustomerWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [CustomerWithdrawalController::class, 'history'])->name('withdraw.history');

    // Customer Advisors
    Route::get('/advisors/view', [CustomerAdvisorsController::class, 'view'])->name('advisors.view');
    Route::post('/advisors/store', [CustomerAdvisorsController::class, 'store'])->name('advisors.store');
    Route::post('/advisors/update/{id}', [CustomerAdvisorsController::class, 'update'])->name('advisors.update');
    Route::delete('/advisors/destroy/{id}', [CustomerAdvisorsController::class, 'destroy'])->name('advisors.destroy');

    // Customer Executors
    Route::get('/executors/view', [CustomerExecutorsController::class, 'view'])->name('executors.view');
    Route::post('/executors/store', [CustomerExecutorsController::class, 'store'])->name('executors.store');
    Route::post('/executors/update/{id}', [CustomerExecutorsController::class, 'update'])->name('executors.update');
    Route::delete('/executors/destroy/{id}', [CustomerExecutorsController::class, 'destroy'])->name('executors.destroy');

    // Custom Documents Type
    Route::post('/documents/save_custom_type', [CustomerDocumentsController::class, 'saveCustomType'])->name('documents.save_custom_type');
    // Customer Documents
    Route::get('/documents/view', [CustomerDocumentsController::class, 'view'])->name('documents.view');
    Route::post('/documents/store', [CustomerDocumentsController::class, 'store'])->name('documents.store');
    Route::post('/documents/update/{id}', [CustomerDocumentsController::class, 'update'])->name('documents.update');
    Route::delete('/documents/destroy/{id}', [CustomerDocumentsController::class, 'destroy'])->name('documents.destroy');

    // Reviews
    Route::post('reviews', [CustomerReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [CustomerReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [CustomerReviewController::class, 'destroy'])->name('reviews.destroy');

    // Customer Bank
    Route::get('/bank_accounts/view', [CustomerBankAccountController::class, 'view'])->name('bank_accounts.view');
    Route::post('/bank_accounts/store', [CustomerBankAccountController::class, 'store'])->name('bank_accounts.store');
    Route::post('/bank_accounts/update/{id}', [CustomerBankAccountController::class, 'update'])->name('bank_accounts.update');
    Route::delete('/bank_accounts/destroy/{id}', [CustomerBankAccountController::class, 'destroy'])->name('bank_accounts.destroy');

    // Custom Investment Types
    Route::post('/investment_accounts/save_custom_type', [CustomerInvestmentAccountController::class, 'saveCustomType'])->name('investment_accounts.save_custom_type');
    // Customer Savings
    Route::get('/investment_accounts/view', [CustomerInvestmentAccountController::class, 'view'])->name('investment_accounts.view');
    Route::post('/investment_accounts/store', [CustomerInvestmentAccountController::class, 'store'])->name('investment_accounts.store');
    Route::post('/investment_accounts/update/{id}', [CustomerInvestmentAccountController::class, 'update'])->name('investment_accounts.update');
    Route::delete('/investment_accounts/destroy/{id}', [CustomerInvestmentAccountController::class, 'destroy'])->name('investment_accounts.destroy');

    // Custom Property Type
    Route::post('/properties/save_custom_type', [CustomerPropertyController::class, 'saveCustomType'])->name('properties.save_custom_type');
    // Customer Property (ies) Owned
    Route::get('/properties/view', [CustomerPropertyController::class, 'view'])->name('properties.view');
    Route::post('/properties/store', [CustomerPropertyController::class, 'store'])->name('properties.store');
    Route::put('/properties/update/{id}', [CustomerPropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{id}', [CustomerPropertyController::class, 'destroy'])->name('properties.destroy');

    //Customer Custom Chattels
    Route::post('/personal_chattels/save_custom_type', [CustomerPersonalChattelController::class, 'saveCustomType'])->name('personal_chattels.save_custom_type');

    // Customer Chattels
    Route::get('/personal_chattels/view', [CustomerPersonalChattelController::class, 'view'])->name('personal_chattels.view');
    Route::post('/personal_chattels/store', [CustomerPersonalChattelController::class, 'store'])->name('personal_chattels.store');
    Route::post('/personal_chattels/update/{id}', [CustomerPersonalChattelController::class, 'update'])->name('personal_chattels.update');
    Route::delete('/personal_chattels/destroy/{id}', [CustomerPersonalChattelController::class, 'destroy'])->name('personal_chattels.destroy');

    // Custom Business Types
    Route::post('/business_interests/save_custom_type', [CustomerBusinessInterestController::class, 'saveCustomType'])->name('business_interests.save_custom_type');
    // Customer Business interests
    Route::get('/business_interests/view', [CustomerBusinessInterestController::class, 'view'])->name('business_interests.view');
    Route::post('/business_interests/store', [CustomerBusinessInterestController::class, 'store'])->name('business_interests.store');
    Route::post('/business_interests/update/{id}', [CustomerBusinessInterestController::class, 'update'])->name('business_interests.update');
    Route::delete('/business_interests/destroy/{id}', [CustomerBusinessInterestController::class, 'destroy'])->name('business_interests.destroy');

    // Custom Insurance Type
    Route::post('/insurance_policies/save_custom_type', [CustomerInsurancePolicyController::class, 'saveCustomType'])->name('insurance_policies.save_custom_type');
    // Customer Insurance Policies
    Route::get('/insurance_policies/view', [CustomerInsurancePolicyController::class, 'view'])->name('insurance_policies.view');
    Route::post('/insurance_policies/store', [CustomerInsurancePolicyController::class, 'store'])->name('insurance_policies.store');
    Route::post('/insurance_policies/update/{id}', [CustomerInsurancePolicyController::class, 'update'])->name('insurance_policies.update');
    Route::delete('/insurance_policies/destroy/{id}', [CustomerInsurancePolicyController::class, 'destroy'])->name('insurance_policies.destroy');

    // Custom Debt Type
    Route::post('/debt_and_liabilities/save_custom_type', [CustomerDebtAndLiabilityController::class, 'saveCustomType'])->name('debt_and_liabilities.save_custom_type');
    // Customer Debt & Liability
    Route::get('/debt_and_liabilities/view', [CustomerDebtAndLiabilityController::class, 'view'])->name('debt_and_liabilities.view');
    Route::post('/debt_and_liabilities/store', [CustomerDebtAndLiabilityController::class, 'store'])->name('debt_and_liabilities.store');
    Route::post('/debt_and_liabilities/update/{id}', [CustomerDebtAndLiabilityController::class, 'update'])->name('debt_and_liabilities.update');
    Route::delete('/debt_and_liabilities/destroy/{id}', [CustomerDebtAndLiabilityController::class, 'destroy'])->name('debt_and_liabilities.destroy');

    // Custom Digital Assets Type
    Route::post('/digital_assets/save_custom_type', [CustomerDigitalAssetController::class, 'saveCustomType'])->name('digital_assets.save_custom_type');
    // Customer Digital Assets
    Route::get('/digital_assets/view', [CustomerDigitalAssetController::class, 'view'])->name('digital_assets.view');
    Route::post('/digital_assets/store', [CustomerDigitalAssetController::class, 'store'])->name('digital_assets.store');
    Route::post('/digital_assets/update/{id}', [CustomerDigitalAssetController::class, 'update'])->name('digital_assets.update');
    Route::delete('/digital_assets/destroy/{id}', [CustomerDigitalAssetController::class, 'destroy'])->name('digital_assets.destroy');

    // Custom Intellectual Property Types
    Route::post('/intellectual_properties/save_custom_type', [CustomerIntellectualPropertyController::class, 'saveCustomType'])->name('intellectual_properties.save_custom_type');
    // Customer Intellectual Property
    Route::get('/intellectual_properties/view', [CustomerIntellectualPropertyController::class, 'view'])->name('intellectual_properties.view');
    Route::post('/intellectual_properties/store', [CustomerIntellectualPropertyController::class, 'store'])->name('intellectual_properties.store');
    Route::post('/intellectual_properties/update/{id}', [CustomerIntellectualPropertyController::class, 'update'])->name('intellectual_properties.update');
    Route::delete('/intellectual_properties/destroy/{id}', [CustomerIntellectualPropertyController::class, 'destroy'])->name('intellectual_properties.destroy');

    // Custom Other Asset Type
    Route::post('/other_assets/save_custom_type', [CustomerOtherAssetController::class, 'saveCustomType'])->name('other_assets.save_custom_type');
    // Customer Other Assets
    Route::get('/other_assets/view', [CustomerOtherAssetController::class, 'view'])->name('other_assets.view');
    Route::post('/other_assets/store', [CustomerOtherAssetController::class, 'store'])->name('other_assets.store');
    Route::post('/other_assets/update/{id}', [CustomerOtherAssetController::class, 'update'])->name('other_assets.update');
    Route::delete('/other_assets/destroy/{id}', [CustomerOtherAssetController::class, 'destroy'])->name('other_assets.destroy');

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

    // OPENAI
    Route::get('/openai/view', [CustomerOpenAIController::class, 'view'])->name('openai.view');
    Route::post('/openai/chat', [CustomerOpenAIController::class, 'chat'])->name('openai.chat');

    Route::post('/messages/send', [CustomerMessageController::class, 'sendMessage']);
    Route::get('/messages/{userId}', [CustomerMessageController::class, 'getMessages']);
    Route::get('/users', [CustomerMessageController::class, 'getUsers']);

    // Assign Permission 
    Route::get('/assign-permissions', [CustomerPermissionController::class, 'getRolesAndPermissions'])->name('assign_permissions_form');
    Route::post('/assign-permissions', [CustomerPermissionController::class, 'assignPermissions'])->name('assign_permissions');

    // LPAVIDEOS
    Route::get('/lpa', [CustomerLPAController::class, 'view'])->name('lpa.view');
});

// Executor-specific routes
Route::middleware(['auth:sanctum', 'role:executor'])->prefix('executor')->group(function () {
    Route::get('/profile', [ExecutorProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [ExecutorProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [ExecutorProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [ExecutorProfileController::class, 'update_password'])->name('profile.update.password');
    Route::get('/dashboard', [ExecutorDashboardController::class, 'index'])->name('dashboard');

    // Customer Withdraw
    Route::get('/withdraw', [ExecutorWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [ExecutorWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [ExecutorWithdrawalController::class, 'history'])->name('withdraw.history');

    Route::get('/guidance', [ExecutorGuidanceController::class, 'view'])->name('guidance.view');
    Route::get('/documents/view', [ExecutorDocumentsController::class, 'view'])->name('documents.view');

    // Reviews
    Route::post('reviews', [ExecutorReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [ExecutorReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [ExecutorReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/wishes', [ExecutorWishesController::class, 'view'])->name('wishes.view');
    Route::get('/life-remembered', [ExecutorLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::get('/voice-notes', [ExecutorVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::get('/organs-donations', [ExecutorOrgansDonationController::class, 'view'])->name('organs_donations.view');

    Route::get('/bank_accounts', [ExecutorBankAccountController::class, 'index'])->name('bank_accounts.index');
    Route::get('/investment_accounts', [ExecutorInvestmentAccountController::class, 'index'])->name('investment_accounts.view');
    Route::get('/properties', [ExecutorPropertyController::class, 'index'])->name('properties.view');
    Route::get('/personal_chattels', [ExecutorPersonalChattelController::class, 'index'])->name('personal_chattels.view');
    Route::get('/business_interests', [ExecutorBusinessInterestController::class, 'index'])->name('business_interests.view');
    Route::get('/insurance_policies', [ExecutorInsurancePolicyController::class, 'index'])->name('insurance_policies.view');
    Route::get('/debt_and_liabilities', [ExecutorDebtAndLiabilityController::class, 'index'])->name('debt_and_liabilities.view');
    Route::get('/digital_assets', [ExecutorDigitalAssetController::class, 'index'])->name('digital_assets.view');
    Route::get('/intellectual_properties', [ExecutorIntellectualPropertyController::class, 'index'])->name('intellectual_properties.view');
    Route::get('/other_assets', [ExecutorOtherAssetController::class, 'index'])->name('other_assets.view');

    Route::post('/messages/send', [ExecutorMessageController::class, 'sendMessage']);
    Route::get('/messages/{userId}', [ExecutorMessageController::class, 'getMessages']);
    Route::get('/users', [ExecutorMessageController::class, 'getUsers']);


    // OPENAI
    Route::get('/openai/view', [ExecutorOpenAIController::class, 'view'])->name('openai.view');
    Route::post('/openai/chat', [ExecutorOpenAIController::class, 'chat'])->name('openai.chat');

    // LPAVIDEOS
    Route::get('/lpa', [ExecutorLPAController::class, 'view'])->name('lpa.view');
});
