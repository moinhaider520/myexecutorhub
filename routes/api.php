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
use App\Http\Controllers\Api\Partner\LifeRememberedVideoController as PartnerLifeRememberedVideoController;
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
use App\Http\Controllers\Api\Partner\TaskController as PartnerTaskController;
use App\Http\Controllers\Api\Partner\WillController as PartnerWillController;
use App\Http\Controllers\Api\Partner\FuneralWakeController as PartnerFuneralWakeController;
use App\Http\Controllers\Api\Partner\PicturesAndVideosController as PartnerPicturesAndVideosController;
use App\Http\Controllers\Api\Partner\ForeignAssetsController as PartnerForeignAssetsController;
use App\Http\Controllers\Api\Partner\FuneralPlanController as PartnerFuneralPlanController;
use App\Http\Controllers\Api\Partner\PensionController as PartnerPensionController;
use App\Http\Controllers\Api\Partner\PictureController as PartnerPictureController;
use App\Http\Controllers\Api\Partner\VideoController as PartnerVideoController;
use App\Http\Controllers\Api\Partner\OtherTypeofAssetController as PartnerOtherTypeofAssetController;

// Customer
use App\Http\Controllers\Api\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Api\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Api\Customer\GuidanceController as CustomerGuidanceController;
use App\Http\Controllers\Api\Customer\WishesController as CustomerWishesController;
use App\Http\Controllers\Api\Customer\LifeRememberedController as CustomerLifeRememberedController;
use App\Http\Controllers\Api\Customer\LifeRememberedVideoController as CustomerLifeRememberedVideoController;
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
use App\Http\Controllers\Api\Customer\TaskController as CustomerTaskController;
use App\Http\Controllers\Api\Customer\WillController as CustomerWillController;
use App\Http\Controllers\Api\Customer\FuneralWakeController as CustomerFuneralWakeController;
use App\Http\Controllers\Api\Customer\PicturesAndVideosController as CustomerPicturesAndVideosController;
use App\Http\Controllers\Api\Customer\ForeignAssetsController as CustomerForeignAssetsController;
use App\Http\Controllers\Api\Customer\FuneralPlanController as CustomerFuneralPlanController;
use App\Http\Controllers\Api\Customer\PensionController as CustomerPensionController;
use App\Http\Controllers\Api\Customer\PictureController as CustomerPictureController;
use App\Http\Controllers\Api\Customer\VideoController as CustomerVideoController;
use App\Http\Controllers\Api\Customer\OtherTypeofAssetController as CustomerOtherTypeofAssetController;
use App\Http\Controllers\Api\Customer\WillGeneratorController;
// Executor
use App\Http\Controllers\Api\Executor\ProfileController as ExecutorProfileController;
use App\Http\Controllers\Api\Executor\DashboardController as ExecutorDashboardController;
use App\Http\Controllers\Api\Executor\GuidanceController as ExecutorGuidanceController;
use App\Http\Controllers\Api\Executor\WishesController as ExecutorWishesController;
use App\Http\Controllers\Api\Executor\LifeRememberedController as ExecutorLifeRememberedController;
use App\Http\Controllers\Api\Executor\LifeRememberedVideoController as ExecutorLifeRememberedVideoController;
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
use App\Http\Controllers\Api\Executor\TaskController as ExecutorTaskController;
use App\Http\Controllers\Api\Executor\WillController as ExecutorWillController;
use App\Http\Controllers\Api\Executor\FuneralWakeController as ExecutorFuneralWakeController;
use App\Http\Controllers\Api\Executor\PicturesAndVideosController as ExecutorPicturesAndVideosController;
use App\Http\Controllers\Api\Executor\ForeignAssetsController as ExecutorForeignAssetsController;
use App\Http\Controllers\Api\Executor\FuneralPlanController as ExecutorFuneralPlanController;
use App\Http\Controllers\Api\Executor\PensionController as ExecutorPensionController;
use App\Http\Controllers\Api\Executor\PictureController as ExecutorPictureController;
use App\Http\Controllers\Api\Executor\VideoController as ExecutorVideoController;
use App\Http\Controllers\Api\Executor\OtherTypeofAssetController as ExecutorOtherTypeofAssetController;
use App\Http\Controllers\Api\Executor\WillGeneratorController as ExecutorWillGeneratorController;

// General Controllers
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ExpoController;
use App\Http\Controllers\Api\Partner\WillGeneratorController as PartnerWillGeneratorController;
use Stripe\Customer;


use App\Http\Controllers\Api\StripePaymentController;

Route::post('/stripe-payment', [StripePaymentController::class, 'stripePayment']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Authentication routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('/verify-two-factor', [LoginController::class, 'verifyTwoFactor']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/send_reset_password_email', [ForgetPasswordController::class, 'send_reset_password_email']);

// Route to update the expo token
Route::post('/expo/update-token/{id}', [ExpoController::class, 'updateExpoToken'])->name('expo.update-token');

    Route::get('will_generator/create_pdf/{will_user_id}',[PartnerWillGeneratorController::class,'create_pdf'])->name('will_generator.create_pdf');
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
    Route::post('/dashboard/store-location', [PartnerDashboardController::class, 'storeDocumentLocation'])->name('dashboard.store-location');
    Route::post('/dashboard/update-location/{id}', [PartnerDashboardController::class, 'updateLocation'])->name('dashboard.update-location');
    Route::delete('/dashboard/delete-location/{id}', [PartnerDashboardController::class, 'deleteLocation'])->name('dashboard.delete-location');

    // Partner Withdraw
    Route::get('/withdraw', [PartnerWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [PartnerWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [PartnerWithdrawalController::class, 'history'])->name('withdraw.history');

    // Partner Advisors
    Route::get('/advisors/view', [PartnerAdvisorsController::class, 'view'])->name('advisors.view');
    Route::post('/advisors/store', [PartnerAdvisorsController::class, 'store'])->name('advisors.store');
    Route::post('/advisors/update/{id}', [PartnerAdvisorsController::class, 'update'])->name('advisors.update');
    Route::delete('/advisors/destroy/{id}', [PartnerAdvisorsController::class, 'destroy'])->name('advisors.destroy');

    // Partner Funeral Wake
    Route::get('/funeral_wake/view', [PartnerFuneralWakeController::class, 'view'])->name('funeral_wake.view');
    Route::post('/funeral_wake/store', [PartnerFuneralWakeController::class, 'store'])->name('funeral_wake.store');
    Route::post('/funeral_wake/update/{id}', [PartnerFuneralWakeController::class, 'update'])->name('funeral_wake.update');
    Route::delete('/funeral_wake/destroy/{id}', [PartnerFuneralWakeController::class, 'destroy'])->name('funeral_wake.destroy');

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
    Route::get('/documents/view/{document_type}', [PartnerDocumentsController::class, 'ViewByDocType'])->name('documents.viewByDocType');

    // Partner Funeral Plan Types
    Route::post('/funeral_plans/save_custom_type', [PartnerFuneralPlanController::class, 'saveCustomType'])->name('funeral_plans.save_custom_type');
    // Partner Funeral Plans
    Route::get('/funeral_plans/view', [PartnerFuneralPlanController::class, 'view'])->name('funeral_plans.view');
    Route::post('/funeral_plans/store', [PartnerFuneralPlanController::class, 'store'])->name('funeral_plans.store');
    Route::post('/funeral_plans/update/{id}', [PartnerFuneralPlanController::class, 'update'])->name('funeral_plans.update');
    Route::delete('/funeral_plans/destroy/{id}', [PartnerFuneralPlanController::class, 'destroy'])->name('funeral_plans.destroy');

    // Partner Pictures AND VIDEOS
    Route::get('/pictures_and_videos/view', [PartnerPicturesAndVideosController::class, 'view'])->name('pictures_and_videos.view');
    Route::post('/pictures_and_videos/store', [PartnerPicturesAndVideosController::class, 'store'])->name('pictures_and_videos.store');
    Route::post('/pictures_and_videos/update/{id}', [PartnerPicturesAndVideosController::class, 'update'])->name('pictures_and_videos.update');
    Route::delete('/pictures_and_videos/destroy/{id}', [PartnerPicturesAndVideosController::class, 'destroy'])->name('pictures_and_videos.destroy');

    // PICTURES CONTROLLER
    Route::get('/pictures/view', [PartnerPictureController::class, 'view'])->name('pictures.view');
    Route::post('/pictures/store', [PartnerPictureController::class, 'store'])->name('pictures.store');
    Route::post('/pictures/update/{id}', [PartnerPictureController::class, 'update'])->name('pictures.update');
    Route::delete('/pictures/destroy/{id}', [PartnerPictureController::class, 'destroy'])->name('pictures.destroy');

    // VIDEOS CONTROLLER
    Route::get('/videos/view', [PartnerVideoController::class, 'view'])->name('videos.view');
    Route::post('/videos/store', [PartnerVideoController::class, 'store'])->name('videos.store');
    Route::post('/videos/update/{id}', [PartnerVideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/destroy/{id}', [PartnerVideoController::class, 'destroy'])->name('videos.destroy');

    // Reviews
    Route::post('reviews', [PartnerReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [PartnerReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [PartnerReviewController::class, 'destroy'])->name('reviews.destroy');

    // Partner Bank
    Route::get('/bank_accounts/view', [PartnerBankAccountController::class, 'view'])->name('bank_accounts.view');
    Route::post('/bank_accounts/store', [PartnerBankAccountController::class, 'store'])->name('bank_accounts.store');
    Route::post('/bank_accounts/update/{id}', [PartnerBankAccountController::class, 'update'])->name('bank_accounts.update');
    Route::delete('/bank_accounts/destroy/{id}', [PartnerBankAccountController::class, 'destroy'])->name('bank_accounts.destroy');
    Route::post('/bank_accounts/save_custom_type', [PartnerBankAccountController::class, 'saveCustomType'])->name('bank_accounts.save_custom_type');

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

    // Custom Other Type of Asset Type
    Route::post('/other_type_of_assets/save_custom_type', [PartnerOtherTypeofAssetController::class, 'saveCustomType'])->name('other_type_of_assets.save_custom_type');
    // Customer Other Type of Assets
    Route::get('/other_type_of_assets/view', [PartnerOtherTypeofAssetController::class, 'view'])->name('other_type_of_assets.view');
    Route::post('/other_type_of_assets/store', [PartnerOtherTypeofAssetController::class, 'store'])->name('other_type_of_assets.store');
    Route::post('/other_type_of_assets/update/{id}', [PartnerOtherTypeofAssetController::class, 'update'])->name('other_type_of_assets.update');
    Route::delete('/other_type_of_assets/destroy/{id}', [PartnerOtherTypeofAssetController::class, 'destroy'])->name('other_type_of_assets.destroy');

    // Partner Foreign Asset Type
    Route::post('/foreign_assets/save_custom_type', [PartnerForeignAssetsController::class, 'saveCustomType'])->name('foreign_assets.save_custom_type');
    // Partner Foreign Assets
    Route::get('/foreign_assets/view', [PartnerForeignAssetsController::class, 'view'])->name('foreign_assets.view');
    Route::post('/foreign_assets/store', [PartnerForeignAssetsController::class, 'store'])->name('foreign_assets.store');
    Route::post('/foreign_assets/update/{id}', [PartnerForeignAssetsController::class, 'update'])->name('foreign_assets.update');
    Route::delete('/foreign_assets/destroy/{id}', [PartnerForeignAssetsController::class, 'destroy'])->name('foreign_assets.destroy');

    // Partner pensions
    Route::get('/pension/view', [PartnerPensionController::class, 'view'])->name('pensions.view');
    Route::post('/pension/store', [PartnerPensionController::class, 'store'])->name('pensions.store');
    Route::post('/pension/update/{id}', [PartnerPensionController::class, 'update'])->name('pensions.update');
    Route::delete('/pension/destroy/{id}', [PartnerPensionController::class, 'destroy'])->name('pensions.destroy');

    Route::get('/guidance/view', [PartnerGuidanceController::class, 'view'])->name('guidance.view');
    Route::post('/guidance/store', [PartnerGuidanceController::class, 'store'])->name('guidance.store');
    Route::get('/guidance/{id}/media', [PartnerGuidanceController::class, 'getMedia']);
    Route::delete('/guidance/media/{id}', [PartnerGuidanceController::class, 'deleteMedia']);
    Route::post('/guidance/update', [PartnerGuidanceController::class, 'update'])->name('guidance.update');
    Route::post('/guidance/update/{id}', [PartnerGuidanceController::class, 'update'])->name('guidance.update');
    Route::delete('/guidance/destroy/{id}', [PartnerGuidanceController::class, 'destroy'])->name('guidance.destroy');

    Route::get('/wishes/view', [PartnerWishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/store', [PartnerWishesController::class, 'store'])->name('wishes.store');
    Route::get('/wishes/{id}/media', [PartnerWishesController::class, 'getMedia']);
    Route::delete('/wishes/media/{id}', [PartnerWishesController::class, 'deleteMedia']);
    Route::post('/wishes/update', [PartnerWishesController::class, 'update'])->name('wishes.update');
    Route::post('/wishes/update/{id}', [PartnerWishesController::class, 'update'])->name('wishes.update');
    Route::delete('/wishes/destroy/{id}', [PartnerWishesController::class, 'destroy'])->name('wishes.destroy');

    Route::get('/life_remembered/view', [PartnerLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::post('/life_remembered/store', [PartnerLifeRememberedController::class, 'store'])->name('life_remembered.store');
    Route::get('/life_remembered/{id}/media', [PartnerLifeRememberedController::class, 'getMedia']);
    Route::delete('/life_remembered/media/{id}', [PartnerLifeRememberedController::class, 'deleteMedia']);
    Route::post('/life_remembered/update', [PartnerLifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::post('/life_remembered/update/{id}', [PartnerLifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::delete('/life_remembered/destroy/{id}', [PartnerLifeRememberedController::class, 'destroy'])->name('life_remembered.destroy');

    Route::get('/life_remembered_videos/view', [PartnerLifeRememberedVideoController::class, 'view'])->name('life_remembered_videos.view');
    Route::post('/life_remembered_videos/store', [PartnerLifeRememberedVideoController::class, 'store'])->name('life_remembered_videos.store');
    Route::get('/life_remembered_videos/{id}/media', [PartnerLifeRememberedVideoController::class, 'getMedia']);
    Route::delete('/life_remembered_videos/media/{id}', [PartnerLifeRememberedVideoController::class, 'deleteMedia']);
    Route::post('/life_remembered_videos/update/{id}', [PartnerLifeRememberedVideoController::class, 'update'])->name('life_remembered_videos.update');
    Route::delete('/life_remembered_videos/destroy/{id}', [PartnerLifeRememberedVideoController::class, 'destroy'])->name('life_remembered_videos.destroy');

    Route::get('/voice-notes', [PartnerVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::post('/voice-notes', [PartnerVoiceNotesController::class, 'store'])->name('voice_notes.store');
    Route::delete('/voice-notes/{id}', [PartnerVoiceNotesController::class, 'destroy'])->name('voice_notes.destroy');

    Route::get('/organs-donations', [PartnerOrgansDonationController::class, 'view'])->name('organs_donations.view');
    Route::post('/organs-donations', [PartnerOrgansDonationController::class, 'store'])->name('organs_donations.store');
    Route::put('/organs-donations/{id}', [PartnerOrgansDonationController::class, 'update'])->name('organs_donations.update');
    Route::delete('/organs-donations/{id}', [PartnerOrgansDonationController::class, 'destroy'])->name('organs_donations.destroy');


    // TASKS
    Route::get('/tasks', [PartnerTaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [PartnerTaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{id}', [PartnerTaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [PartnerTaskController::class, 'destroy'])->name('tasks.destroy');

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

    // WILLS
    Route::get('/wills', [PartnerWillController::class, 'view'])->name('wills.view');

    Route::get('/will_generator/partner_about_you', [PartnerWillGeneratorController::class, 'partner_about_you'])->name('wills.partner_about_you');
    Route::get('/will_generator/about_you/{id}', [PartnerWillGeneratorController::class, 'about_you'])->name('wills.about_you');
    Route::post('/will_generator/store_about_you', [PartnerWillGeneratorController::class, 'store_about_you'])->name('wills.store_about_you');
    Route::post('/will_generator/edit_about_you/{id}', [PartnerWillGeneratorController::class, 'update_about_you'])->name('will_generator.update_about_you');

    // will generator children and pets
    Route::get('/will_generator/child/{will_user_id}', [PartnerWillGeneratorController::class, 'child'])->name('will_generator.child');
    Route::post('/will_generator/store_child/{will_user_id}', [PartnerWillGeneratorController::class, 'store_user_child'])->name('will_generator.store_child');
    Route::post('/will_generator/edit_child/{id}', [PartnerWillGeneratorController::class, 'edit_user_child'])->name('will_generator.edit_child');
    Route::delete('/will_generator/delete_child/{id}', [PartnerWillGeneratorController::class, 'delete_user_child'])->name('will_generator.delete_child');

    Route::get('/will_generator/pet/{will_user_id}', [PartnerWillGeneratorController::class, 'pet'])->name('will_generator.pet');
    Route::post('/will_generator/store_pet/{will_user_id}', [PartnerWillGeneratorController::class, 'store_user_pet'])->name('will_generator.store_pet');
    Route::post('/will_generator/edit_pet/{id}', [PartnerWillGeneratorController::class, 'edit_user_pet'])->name('will_generator.edit_pet');
    Route::delete('/will_generator/delete_pet/{id}', [PartnerWillGeneratorController::class, 'delete_user_pet'])->name('will_generator.delete_pet');

    //will generator partner
    Route::get('will_generator/user_partner/{will_user_id}', [PartnerWillGeneratorController::class, 'user_partner'])->name('will_generator.user_partner');
    Route::post('will_generator/user_partner/store/{will_user_id}', [PartnerWillGeneratorController::class, 'store_user_partner'])->name('will_generator.user_partner.store');
    Route::post('will_generator/user_partner/edit/{id}', [PartnerWillGeneratorController::class, 'edit_user_partner'])->name('will_generator.user_partner.edit');
    Route::delete('will_generator/user_partner/delete/{id}', [PartnerWillGeneratorController::class, 'delete_user_partner'])->name('will_generator.user_partner.delete');


    //account properties
    Route::get('will_generator/account_properties/{will_user_id}', [PartnerWillGeneratorController::class, 'account_properties'])->name('will_generator.account_properties');
    Route::post('will_generator/account_properties/store/{will_user_id}', [PartnerWillGeneratorController::class, 'store_account_properties'])->name('will_generator.account_properties.store');
    Route::post('will_generator/account_properties/update/{id}', [PartnerWillGeneratorController::class, 'update_account_properties'])->name('will_generator.account_properties.update');
    Route::delete('will_generator/account_properties/delete/{id}', [PartnerWillGeneratorController::class, 'delete_account_properties'])->name('will_generator.account_properties.delete');


    // will generator funeral plan
    Route::get('will_generator/funeral_plan/{will_user_id}', [PartnerWillGeneratorController::class, 'funeral_plan'])->name('will_generator.funeral_plan');
    Route::post('will_generator/store_funeral_plan/{will_user_id}', [PartnerWillGeneratorController::class, 'store_funeral_plan'])->name('will_generator.store_funeral_plan');



    // will generator gifts
    Route::get('will_generator/gift/{will_user_id}', [PartnerWillGeneratorController::class, 'gift'])->name('will_generator.gift');
    Route::post('will_generator/gift/store_add_gift/{will_user_id}', [PartnerWillGeneratorController::class, 'store_add_gift'])->name('will_generator.gift.store_add_gift');
    Route::post('will_generator/gift/update_gift/{id}', [PartnerWillGeneratorController::class, 'update_gift'])->name('will_generator.gift.update_gift');
    Route::delete('will_generator/gift/delete/{id}', [PartnerWillGeneratorController::class, 'delete_gift'])->name('will_generator.gift.delete_gift');


    // will generator step 3
    Route::get('will_generator/family_friend/{will_user_id}', [PartnerWillGeneratorController::class, 'family_friend'])->name('will_generator.family_friend');
    Route::post('will_generator/executor/store_family_friend/{will_user_id}', [PartnerWillGeneratorController::class, 'store_family_friend'])->name('will_generator.store_family_friend');

    // will generator inherited charity
    Route::get('will_generator/charities', [PartnerWillGeneratorController::class, 'charities'])->name('will_generator.charities');
    Route::get('will_generator/inherited_charity/{will_user_id}', [PartnerWillGeneratorController::class, 'inherited_charity'])->name('will_generator.inherited_charity');
    Route::post('will_generator/charity/store', [PartnerWillGeneratorController::class, 'store_charity'])->name('will_generator.store_charity');

    // will generator estate
    Route::get('will_generator/benificaries_death_backup/{will_user_id}', [PartnerWillGeneratorController::class, 'benificaries_death_backup'])->name('will_generator.benificaries_death_backup');
    Route::post('will_generator/store_benificaries_death_backup/{will_user_id}', [PartnerWillGeneratorController::class, 'store_benificaries_death_backup'])->name('will_generator.store_benificaries_death_backup');
    Route::get('will_generator/estate/summary/{will_user_id}', [PartnerWillGeneratorController::class, 'estate_summary'])->name('will_generator.estate.summary');
    Route::post('will_generator/estate/store_estate_summary/{will_user_id}', [PartnerWillGeneratorController::class, 'store_estate_summary'])->name('will_generator.estate.store_estate_summary');


    Route::get('will_generator/executor/{will_user_id}', [PartnerWillGeneratorController::class, 'executors'])->name('will_generator.estate.store_estate_summary');
    Route::post('will_generator/executor/store/{will_user_id}', [PartnerWillGeneratorController::class, 'store_executor'])->name('will_generator.store_executor');
});

// Customer-specific routes
Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/profile', [CustomerProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [CustomerProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [CustomerProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [CustomerProfileController::class, 'update_password'])->name('profile.update.password');

    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/store-location', [CustomerDashboardController::class, 'storeDocumentLocation'])->name('dashboard.store-location');
    Route::post('/dashboard/update-location/{id}', [CustomerDashboardController::class, 'updateLocation'])->name('dashboard.update-location');
    Route::delete('delete-location/{id}', [CustomerDashboardController::class, 'deleteLocation'])->name('dashboard.delete-location');

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
    Route::get('/documents/view/{document_type}', [CustomerDocumentsController::class, 'ViewByDocType'])->name('documents.viewByDocType');

    // Custom Funeral Plan Types
    Route::post('/funeral_plans/save_custom_type', [CustomerFuneralPlanController::class, 'saveCustomType'])->name('funeral_plans.save_custom_type');
    // Customer Funeral Plans
    Route::get('/funeral_plans/view', [CustomerFuneralPlanController::class, 'index'])->name('funeral_plans.view');
    Route::post('/funeral_plans/store', [CustomerFuneralPlanController::class, 'store'])->name('funeral_plans.store');
    Route::post('/funeral_plans/update/{id}', [CustomerFuneralPlanController::class, 'update'])->name('funeral_plans.update');
    Route::delete('/funeral_plans/destroy/{id}', [CustomerFuneralPlanController::class, 'destroy'])->name('funeral_plans.destroy');

    // PICTURES & VIDEOS CONTROLLER
    Route::get('/pictures_and_videos/view', [CustomerPicturesAndVideosController::class, 'view'])->name('pictures_and_videos.view');
    Route::post('/pictures_and_videos/store', [CustomerPicturesAndVideosController::class, 'store'])->name('pictures_and_videos.store');
    Route::post('/pictures_and_videos/update/{id}', [CustomerPicturesAndVideosController::class, 'update'])->name('pictures_and_videos.update');
    Route::delete('/pictures_and_videos/destroy/{id}', [CustomerPicturesAndVideosController::class, 'destroy'])->name('pictures_and_videos.destroy');

    // PICTURES CONTROLLER
    Route::get('/pictures/view', [CustomerPictureController::class, 'index'])->name('pictures.view');
    Route::post('/pictures/store', [CustomerPictureController::class, 'store'])->name('pictures.store');
    Route::post('/pictures/update/{id}', [CustomerPictureController::class, 'update'])->name('pictures.update');
    Route::delete('/pictures/destroy/{id}', [CustomerPictureController::class, 'destroy'])->name('pictures.destroy');

    // VIDEOS CONTROLLER
    Route::get('/videos/view', [CustomerVideoController::class, 'index'])->name('videos.view');
    Route::post('/videos/store', [CustomerVideoController::class, 'store'])->name('videos.store');
    Route::post('/videos/update/{id}', [CustomerVideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/destroy/{id}', [CustomerVideoController::class, 'destroy'])->name('videos.destroy');

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

    // Custom Other Type of Asset Type
    Route::post('/other_type_of_assets/save_custom_type', [CustomerOtherTypeofAssetController::class, 'saveCustomType'])->name('other_type_of_assets.save_custom_type');
    // Customer Other Type of Assets
    Route::get('/other_type_of_assets/view', [CustomerOtherTypeofAssetController::class, 'index'])->name('other_type_of_assets.view');
    Route::post('/other_type_of_assets/store', [CustomerOtherTypeofAssetController::class, 'store'])->name('other_type_of_assets.store');
    Route::post('/other_type_of_assets/update/{id}', [CustomerOtherTypeofAssetController::class, 'update'])->name('other_type_of_assets.update');
    Route::delete('/other_type_of_assets/destroy/{id}', [CustomerOtherTypeofAssetController::class, 'destroy'])->name('other_type_of_assets.destroy');

    // Custom Foreign Asset Type
    Route::post('/foreign_assets/save_custom_type', [CustomerForeignAssetsController::class, 'saveCustomType'])->name('foreign_assets.save_custom_type');
    // Customer Foreign Assets
    Route::get('/foreign_assets/view', [CustomerForeignAssetsController::class, 'index'])->name('foreign_assets.view');
    Route::post('/foreign_assets/store', [CustomerForeignAssetsController::class, 'store'])->name('foreign_assets.store');
    Route::post('/foreign_assets/update/{id}', [CustomerForeignAssetsController::class, 'update'])->name('foreign_assets.update');
    Route::delete('/foreign_assets/destroy/{id}', [CustomerForeignAssetsController::class, 'destroy'])->name('foreign_assets.destroy');

    // Customer pensions
    Route::get('/pension/view', [CustomerPensionController::class, 'index'])->name('pensions.view');
    Route::post('/pension/store', [CustomerPensionController::class, 'store'])->name('pensions.store');
    Route::post('/pension/update/{id}', [CustomerPensionController::class, 'update'])->name('pensions.update');
    Route::delete('/pension/destroy/{id}', [CustomerPensionController::class, 'destroy'])->name('pensions.destroy');

    Route::get('/guidance/view', [CustomerGuidanceController::class, 'view'])->name('guidance.view');
    Route::post('/guidance/store', [CustomerGuidanceController::class, 'store'])->name('guidance.store');
    Route::get('/guidance/{id}/media', [CustomerGuidanceController::class, 'getMedia']);
    Route::delete('/guidance/media/{id}', [CustomerGuidanceController::class, 'deleteMedia']);
    Route::post('/guidance/update', [CustomerGuidanceController::class, 'update'])->name('guidance.update');
    Route::post('/guidance/update/{id}', [CustomerGuidanceController::class, 'update'])->name('guidance.update');
    Route::delete('/guidance/destroy/{id}', [CustomerGuidanceController::class, 'destroy'])->name('guidance.destroy');

    Route::get('/wishes/view', [CustomerWishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/store', [CustomerWishesController::class, 'store'])->name('wishes.store');
    Route::get('/wishes/{id}/media', [CustomerWishesController::class, 'getMedia']);
    Route::delete('/wishes/media/{id}', [CustomerWishesController::class, 'deleteMedia']);
    Route::post('/wishes/update', [CustomerWishesController::class, 'update'])->name('wishes.update');
    Route::post('/wishes/update/{id}', [CustomerWishesController::class, 'update'])->name('wishes.update');
    Route::delete('/wishes/destroy/{id}', [CustomerWishesController::class, 'destroy'])->name('wishes.destroy');

    Route::get('/life_remembered/view', [CustomerLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::post('/life_remembered/store', [CustomerLifeRememberedController::class, 'store'])->name('life_remembered.store');
    Route::get('/life_remembered/{id}/media', [CustomerLifeRememberedController::class, 'getMedia']);
    Route::delete('/life_remembered/media/{id}', [CustomerLifeRememberedController::class, 'deleteMedia']);
    Route::post('/life_remembered/update', [CustomerLifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::post('/life_remembered/update/{id}', [CustomerLifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::delete('/life_remembered/destroy/{id}', [CustomerLifeRememberedController::class, 'destroy'])->name('life_remembered.destroy');

    Route::get('/life_remembered_videos/view', [CustomerLifeRememberedVideoController::class, 'view'])->name('life_remembered_videos.view');
    Route::post('/life_remembered_videos/store', [CustomerLifeRememberedVideoController::class, 'store'])->name('life_remembered_videos.store');
    Route::get('/life_remembered_videos/{id}/media', [CustomerLifeRememberedVideoController::class, 'getMedia']);
    Route::delete('/life_remembered_videos/media/{id}', [CustomerLifeRememberedVideoController::class, 'deleteMedia']);
    Route::post('/life_remembered_videos/update/{id}', [CustomerLifeRememberedVideoController::class, 'update'])->name('life_remembered_videos.update');
    Route::delete('/life_remembered_videos/destroy/{id}', [CustomerLifeRememberedVideoController::class, 'destroy'])->name('life_remembered_videos.destroy');

    Route::get('/voice-notes', [CustomerVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::post('/voice-notes', [CustomerVoiceNotesController::class, 'store'])->name('voice_notes.store');
    Route::delete('/voice-notes/{id}', [CustomerVoiceNotesController::class, 'destroy'])->name('voice_notes.destroy');

    Route::get('/organs-donations', [CustomerOrgansDonationController::class, 'view'])->name('organs_donations.view');
    Route::post('/organs-donations', [CustomerOrgansDonationController::class, 'store'])->name('organs_donations.store');
    Route::put('/organs-donations/{id}', [CustomerOrgansDonationController::class, 'update'])->name('organs_donations.update');
    Route::delete('/organs-donations/{id}', [CustomerOrgansDonationController::class, 'destroy'])->name('organs_donations.destroy');

    // Task
    Route::get('/tasks', [CustomerTaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [CustomerTaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{id}', [CustomerTaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [CustomerTaskController::class, 'destroy'])->name('tasks.destroy');

    // Funeral Wake
    Route::get('/funeral_wake/view', [CustomerFuneralWakeController::class, 'view'])->name('funeral_wake.view');
    Route::post('/funeral_wake/store', [CustomerFuneralWakeController::class, 'store'])->name('funeral_wake.store');
    Route::post('/funeral_wake/update/{id}', [CustomerFuneralWakeController::class, 'update'])->name('funeral_wake.update');
    Route::delete('/funeral_wake/destroy/{id}', [CustomerFuneralWakeController::class, 'destroy'])->name('funeral_wake.destroy');

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

    // WILLS
    Route::get('/wills', [CustomerWillController::class, 'view'])->name('wills.view');

    Route::get('/will_generator/partner_about_you', [WillGeneratorController::class, 'partner_about_you'])->name('wills.partner_about_you');
    Route::get('/will_generator/about_you/{id}', [WillGeneratorController::class, 'about_you'])->name('wills.about_you');
    Route::post('/will_generator/store_about_you', [WillGeneratorController::class, 'store_about_you'])->name('wills.store_about_you');
    Route::post('/will_generator/edit_about_you/{id}', [WillGeneratorController::class, 'update_about_you'])->name('will_generator.update_about_you');

    // will generator children and pets
    Route::get('/will_generator/child/{will_user_id}', [WillGeneratorController::class, 'child'])->name('will_generator.child');
    Route::post('/will_generator/store_child/{will_user_id}', [WillGeneratorController::class, 'store_user_child'])->name('will_generator.store_child');
    Route::post('/will_generator/edit_child/{id}', [WillGeneratorController::class, 'edit_user_child'])->name('will_generator.edit_child');
    Route::delete('/will_generator/delete_child/{id}', [WillGeneratorController::class, 'delete_user_child'])->name('will_generator.delete_child');

    Route::get('/will_generator/pet/{will_user_id}', [WillGeneratorController::class, 'pet'])->name('will_generator.pet');
    Route::post('/will_generator/store_pet/{will_user_id}', [WillGeneratorController::class, 'store_user_pet'])->name('will_generator.store_pet');
    Route::post('/will_generator/edit_pet/{id}', [WillGeneratorController::class, 'edit_user_pet'])->name('will_generator.edit_pet');
    Route::delete('/will_generator/delete_pet/{id}', [WillGeneratorController::class, 'delete_user_pet'])->name('will_generator.delete_pet');

    //will generator partner
    Route::get('will_generator/user_partner/{will_user_id}', [WillGeneratorController::class, 'user_partner'])->name('will_generator.user_partner');
    Route::post('will_generator/user_partner/store/{will_user_id}', [WillGeneratorController::class, 'store_user_partner'])->name('will_generator.user_partner.store');
    Route::post('will_generator/user_partner/edit/{id}', [WillGeneratorController::class, 'edit_user_partner'])->name('will_generator.user_partner.edit');
    Route::delete('will_generator/user_partner/delete/{id}', [WillGeneratorController::class, 'delete_user_partner'])->name('will_generator.user_partner.delete');


    //account properties
    Route::get('will_generator/account_properties/{will_user_id}', [WillGeneratorController::class, 'account_properties'])->name('will_generator.account_properties');
    Route::post('will_generator/account_properties/store/{will_user_id}', [WillGeneratorController::class, 'store_account_properties'])->name('will_generator.account_properties.store');
    Route::post('will_generator/account_properties/update/{id}', [WillGeneratorController::class, 'update_account_properties'])->name('will_generator.account_properties.update');
    Route::delete('will_generator/account_properties/delete/{id}', [WillGeneratorController::class, 'delete_account_properties'])->name('will_generator.account_properties.delete');


    // will generator funeral plan
    Route::get('will_generator/funeral_plan/{will_user_id}', [WillGeneratorController::class, 'funeral_plan'])->name('will_generator.funeral_plan');
    Route::post('will_generator/store_funeral_plan/{will_user_id}', [WillGeneratorController::class, 'store_funeral_plan'])->name('will_generator.store_funeral_plan');



    // will generator gifts
    Route::get('will_generator/gift/{will_user_id}', [WillGeneratorController::class, 'gift'])->name('will_generator.gift');
    Route::post('will_generator/gift/store_add_gift/{will_user_id}', [WillGeneratorController::class, 'store_add_gift'])->name('will_generator.gift.store_add_gift');
    Route::post('will_generator/gift/update_gift/{id}', [WillGeneratorController::class, 'update_gift'])->name('will_generator.gift.update_gift');
    Route::delete('will_generator/gift/delete/{id}', [WillGeneratorController::class, 'delete_gift'])->name('will_generator.gift.delete_gift');


    // will generator step 3
    Route::get('will_generator/family_friend/{will_user_id}', [WillGeneratorController::class, 'family_friend'])->name('will_generator.family_friend');
    Route::post('will_generator/executor/store_family_friend/{will_user_id}', [WillGeneratorController::class, 'store_family_friend'])->name('will_generator.store_family_friend');

    // will generator inherited charity
    Route::get('will_generator/charities', [WillGeneratorController::class, 'charities'])->name('will_generator.charities');
    Route::get('will_generator/inherited_charity/{will_user_id}', [WillGeneratorController::class, 'inherited_charity'])->name('will_generator.inherited_charity');
    Route::post('will_generator/charity/store', [WillGeneratorController::class, 'store_charity'])->name('will_generator.store_charity');

    // will generator estate
    Route::get('will_generator/benificaries_death_backup/{will_user_id}', [WillGeneratorController::class, 'benificaries_death_backup'])->name('will_generator.benificaries_death_backup');
    Route::post('will_generator/store_benificaries_death_backup/{will_user_id}', [WillGeneratorController::class, 'store_benificaries_death_backup'])->name('will_generator.store_benificaries_death_backup');
    Route::get('will_generator/estate/summary/{will_user_id}', [WillGeneratorController::class, 'estate_summary'])->name('will_generator.estate.summary');
    Route::post('will_generator/estate/store_estate_summary/{will_user_id}', [WillGeneratorController::class, 'store_estate_summary'])->name('will_generator.estate.store_estate_summary');


    Route::get('will_generator/executor/{will_user_id}', [WillGeneratorController::class, 'executors'])->name('will_generator.estate.store_estate_summary');
    Route::post('will_generator/executor/store/{will_user_id}', [WillGeneratorController::class, 'store_executor'])->name('will_generator.store_executor');
});

// Executor-specific routes
Route::middleware(['auth:sanctum', 'role:executor'])->prefix('executor')->group(function () {
    Route::get('/profile', [ExecutorProfileController::class, 'user_details'])->name('profile');
    Route::post('/profile/update', [ExecutorProfileController::class, 'update_profile'])->name('profile.update');
    Route::post('/profile/picture', [ExecutorProfileController::class, 'picture_update'])->name('profile.picture');
    Route::post('/profile/change/password', [ExecutorProfileController::class, 'update_password'])->name('profile.update.password');
    Route::get('/dashboard', [ExecutorDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-todo', [ExecutorDashboardController::class, 'updateTodoStatus'])->name('dashboard.update-todo');

    // Customer Withdraw
    Route::get('/withdraw', [ExecutorWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [ExecutorWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [ExecutorWithdrawalController::class, 'history'])->name('withdraw.history');

    Route::get('/guidance', [ExecutorGuidanceController::class, 'view'])->name('guidance.view');
    Route::get('/documents/view', [ExecutorDocumentsController::class, 'view'])->name('documents.view');
    Route::get('/pictures_and_videos/view', [ExecutorPicturesAndVideosController::class, 'view'])->name('pictures_and_videos.view');
    Route::get('/pictures/view', [ExecutorPictureController::class, 'view'])->name('pictures.view');
    Route::get('/videos/view', [ExecutorVideoController::class, 'view'])->name('videos.view');

    // Reviews
    Route::post('reviews', [ExecutorReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [ExecutorReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [ExecutorReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/wishes', [ExecutorWishesController::class, 'view'])->name('wishes.view');
    Route::get('/life-remembered', [ExecutorLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::get('/life_remembered_videos/view', [ExecutorLifeRememberedVideoController::class, 'view'])->name('life_remembered_videos.view');
    Route::get('/voice-notes', [ExecutorVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::get('/organs-donations', [ExecutorOrgansDonationController::class, 'view'])->name('organs_donations.view');
    Route::get('/funeral_wake/view', [ExecutorFuneralWakeController::class, 'view'])->name('funeral_wake.view');
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
    Route::get('/other_type_of_assets/view', [ExecutorOtherTypeOfAssetController::class, 'view'])->name('other_type_of_assets.view');
    Route::get('/pension/view', [ExecutorPensionController::class, 'view'])->name('pensions.view');
    Route::get('/funeral_plans/view', [ExecutorFuneralPlanController::class, 'view'])->name('funeral_plans.view');
    Route::get('/foreign_assets/view', [ExecutorForeignAssetsController::class, 'view'])->name('foreign_assets.view');
    Route::get('/tasks', [ExecutorTaskController::class, 'index'])->name('tasks.index');

    Route::post('/messages/send', [ExecutorMessageController::class, 'sendMessage']);
    Route::get('/messages/{userId}', [ExecutorMessageController::class, 'getMessages']);
    Route::get('/users', [ExecutorMessageController::class, 'getUsers']);


    // OPENAI
    Route::get('/openai/view', [ExecutorOpenAIController::class, 'view'])->name('openai.view');
    Route::post('/openai/chat', [ExecutorOpenAIController::class, 'chat'])->name('openai.chat');

    // LPAVIDEOS
    Route::get('/lpa', [ExecutorLPAController::class, 'view'])->name('lpa.view');

    // WILLS
    Route::get('/wills', [ExecutorWillController::class, 'view'])->name('wills.view');

    // WILL GENERATOR
     Route::get('/will_generator/partner_about_you', [ExecutorWillGeneratorController::class, 'partner_about_you'])->name('wills.partner_about_you');
});
