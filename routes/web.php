<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\LPAController as LPAControllerMobile;
use App\Http\Controllers\WillController as WillControllerMobile;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\EmailController as AdminEmailController;

// Role Partner Controller
use App\Http\Controllers\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Partner\SettingController as PartnerSettingController;
use App\Http\Controllers\Partner\BankAccountController as PartnerBankAccountController;
use App\Http\Controllers\Partner\InvestmentAccountController as PartnerInvestmentAccountController;
use App\Http\Controllers\Partner\PropertyController as PartnerPropertyController;
use App\Http\Controllers\Partner\PersonalChattelController as PartnerPersonalChattelController;
use App\Http\Controllers\Partner\PermissionController as PartnerPermissionController;
use App\Http\Controllers\Partner\BusinessInterestController as PartnerBusinessInterestController;
use App\Http\Controllers\Partner\InsurancePolicyController as PartnerInsurancePolicyController;
use App\Http\Controllers\Partner\DebtAndLiabilityController as PartnerDebtAndLiabilityController;
use App\Http\Controllers\Partner\DigitalAssetController as PartnerDigitalAssetController;
use App\Http\Controllers\Partner\IntellectualPropertyController as PartnerIntellectualPropertyController;
use App\Http\Controllers\Partner\OtherAssetController as PartnerOtherAssetController;
use App\Http\Controllers\Partner\OtherTypeOfAssetController as PartnerOtherTypeofAssetController;
use App\Http\Controllers\Partner\PensionController as PartnerPensionController;
use App\Http\Controllers\Partner\ForeignAssetsController as PartnerForeignAssetsController;
use App\Http\Controllers\Partner\FuneralPlanController as PartnerFuneralPlanController;
use App\Http\Controllers\Partner\DocumentsController as PartnerDocumentsController;
use App\Http\Controllers\Partner\WishesController as PartnerWishesController;
use App\Http\Controllers\Partner\MemorandumWishController as PartnerMemorandumWishController;
use App\Http\Controllers\Partner\GuidanceController as PartnerGuidanceController;
use App\Http\Controllers\Partner\LifeRememberedController as PartnerLifeRememberedController;
use App\Http\Controllers\Partner\LifeRememberedVideoController as PartnerLifeRememberedVideoController;
use App\Http\Controllers\Partner\AdvisorsController as PartnerAdvisorsController;
use App\Http\Controllers\Partner\ExecutorsController as PartnerExecutorsController;
use App\Http\Controllers\Partner\OrgansDonationController as PartnerOrgansDonationController;
use App\Http\Controllers\Partner\VoiceNotesController as PartnerVoiceNotesController;
use App\Http\Controllers\Partner\MessagesController as PartnerMessagesController;
use App\Http\Controllers\Partner\OpenAIController as PartnerOpenAIController;
use App\Http\Controllers\Partner\ReviewController as PartnerReviewController;
use App\Http\Controllers\Partner\MembershipController as PartnerMembershipController;
use App\Http\Controllers\Partner\WithdrawalController as PartnerWithdrawalController;
use App\Http\Controllers\Partner\PicturesAndVideosController as PartnerPicturesAndVideosController;
use App\Http\Controllers\Partner\PictureController as PartnerPictureController;
use App\Http\Controllers\Partner\VideoController as PartnerVideoController;
use App\Http\Controllers\Partner\NotificationController as PartnerNotificationController;
use App\Http\Controllers\Partner\LPAController as PartnerLPAController;
use App\Http\Controllers\Partner\WillController as PartnerWillController;
use App\Http\Controllers\Partner\TaskController as PartnerTaskController;
use App\Http\Controllers\Partner\FuneralWakeController as PartnerFuneralWakeController;
use App\Http\Controllers\Partner\WillGeneratorController as PartnerWillGeneratorController;
// Role Customer Controller
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\SettingController as CustomerSettingController;
use App\Http\Controllers\Customer\BankAccountController;
use App\Http\Controllers\Customer\InvestmentAccountController;
use App\Http\Controllers\Customer\PropertyController;
use App\Http\Controllers\Customer\PersonalChattelController;
use App\Http\Controllers\Customer\PermissionController;
use App\Http\Controllers\Customer\BusinessInterestController;
use App\Http\Controllers\Customer\InsurancePolicyController;
use App\Http\Controllers\Customer\DebtAndLiabilityController;
use App\Http\Controllers\Customer\DigitalAssetController;
use App\Http\Controllers\Customer\IntellectualPropertyController;
use App\Http\Controllers\Customer\OtherAssetController;
use App\Http\Controllers\Customer\OtherTypeofAssetController;
use App\Http\Controllers\Customer\PensionController;
use App\Http\Controllers\Customer\ForeignAssetsController;
use App\Http\Controllers\Customer\FuneralPlanController;
use App\Http\Controllers\Customer\DocumentsController;
use App\Http\Controllers\Customer\WishesController;
use App\Http\Controllers\Customer\MemorandumWishController;
use App\Http\Controllers\Customer\GuidanceController;
use App\Http\Controllers\Customer\LifeRememberedController;
use App\Http\Controllers\Customer\LifeRememberedVideoController;
use App\Http\Controllers\Customer\AdvisorsController;
use App\Http\Controllers\Customer\ExecutorsController;
use App\Http\Controllers\Customer\OrgansDonationController;
use App\Http\Controllers\Customer\VoiceNotesController;
use App\Http\Controllers\Customer\MessagesController;
use App\Http\Controllers\Customer\OpenAIController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\MembershipController;
use App\Http\Controllers\Customer\WithdrawalController;
use App\Http\Controllers\Customer\PicturesAndVideosController;
use App\Http\Controllers\Customer\PictureController;
use App\Http\Controllers\Customer\VideoController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Customer\LPAController;
use App\Http\Controllers\Customer\WillController;
use App\Http\Controllers\Customer\TaskController;
use App\Http\Controllers\Customer\FuneralWakeController;

// Role Executor Controller
use App\Http\Controllers\Executor\DashboardController as ExecutorDashboardController;
use App\Http\Controllers\Executor\LifeRememberedController as ExecutorLifeRememberedController;
use App\Http\Controllers\Executor\LifeRememberedVideoController as ExecutorLifeRememberedVideoController;
use App\Http\Controllers\Executor\WishesController as ExecutorWishesController;
use App\Http\Controllers\Executor\MemorandumWishController as ExecutorMemorandumWishController;
use App\Http\Controllers\Executor\GuidanceController as ExecutorGuidanceController;
use App\Http\Controllers\Executor\DocumentsController as ExecutorDocumentsController;
use App\Http\Controllers\Executor\AdvisorsController as ExecutorAdvisorsController;
use App\Http\Controllers\Executor\ExecutorsController as ExecutorExecutorsController;
use App\Http\Controllers\Executor\BankAccountController as ExecutorBankAccountController;
use App\Http\Controllers\Executor\InvestmentAccountController as ExecutorInvestmentAccountController;
use App\Http\Controllers\Executor\PropertyController as ExecutorPropertyController;
use App\Http\Controllers\Executor\PersonalChattelController as ExecutorPersonalChattelController;
use App\Http\Controllers\Executor\BusinessInterestController as ExecutorBusinessInterestController;
use App\Http\Controllers\Executor\InsurancePolicyController as ExecutorInsurancePolicyController;
use App\Http\Controllers\Executor\DebtAndLiabilityController as ExecutorDebtAndLiabilityController;
use App\Http\Controllers\Executor\DigitalAssetController as ExecutorDigitalAssetController;
use App\Http\Controllers\Executor\IntellectualPropertyController as ExecutorIntellectualPropertyController;
use App\Http\Controllers\Executor\OtherAssetController as ExecutorOtherAssetController;
use App\Http\Controllers\Executor\OtherTypeOfAssetController as ExecutorOtherTypeOfAssetController;
use App\Http\Controllers\Executor\PensionController as ExecutorPensionController;
use App\Http\Controllers\Executor\ForeignAssetsController as ExecutorForeignAssetsController;
use App\Http\Controllers\Executor\FuneralPlanController as ExecutorFuneralPlanController;
use App\Http\Controllers\Executor\OrgansDonationController as ExecutorOrgansDonationController;
use App\Http\Controllers\Executor\VoiceNotesController as ExecutorVoiceNotesController;
use App\Http\Controllers\Executor\MessagesController as ExecutorMessagesController;
use App\Http\Controllers\Executor\ReviewController as ExecutorReviewController;
use App\Http\Controllers\Executor\WithdrawalController as ExecutorWithdrawalController;
use App\Http\Controllers\Executor\PicturesAndVideosController as ExecutorPicturesAndVideosController;
use App\Http\Controllers\Executor\PictureController as ExecutorPictureController;
use App\Http\Controllers\Executor\VideoController as ExecutorVideoController;
use App\Http\Controllers\Executor\LPAController as ExecutorLPAController;
use App\Http\Controllers\Executor\WillController as ExecutorWillController;
use App\Http\Controllers\Executor\TaskController as ExecutorTaskController;
use App\Http\Controllers\Executor\FuneralWakeController as ExecutorFuneralWakeController;

// Others Controllers
use App\Http\Controllers\Others\DashboardController as OthersDashboardController;
use App\Http\Controllers\Others\BankAccountController as OthersBankAccountController;
use App\Http\Controllers\Others\InvestmentAccountController as OthersInvestmentAccountController;
use App\Http\Controllers\Others\PropertyController as OthersPropertyController;
use App\Http\Controllers\Others\PersonalChattelController as OthersPersonalChattelController;
use App\Http\Controllers\Others\BusinessInterestController as OthersBusinessInterestController;
use App\Http\Controllers\Others\InsurancePolicyController as OthersInsurancePolicyController;
use App\Http\Controllers\Others\DebtAndLiabilityController as OthersDebtAndLiabilityController;
use App\Http\Controllers\Others\DigitalAssetController as OthersDigitalAssetController;
use App\Http\Controllers\Others\IntellectualPropertyController as OthersIntellectualPropertyController;
use App\Http\Controllers\Others\OtherAssetController as OthersOtherAssetController;
use App\Http\Controllers\Others\OtherTypeOfAssetController as OthersOtherTypeOfAssetController;
use App\Http\Controllers\Others\PensionController as OthersPensionController;
use App\Http\Controllers\Others\ForeignAssetsController as OthersForeignAssetsController;
use App\Http\Controllers\Others\FuneralPlanController as OthersFuneralPlanController;
use App\Http\Controllers\Others\WishesController as OthersWishesController;
use App\Http\Controllers\Others\MemorandumWishController as OthersMemorandumWishController;
use App\Http\Controllers\Others\GuidanceController as OthersGuidanceController;
use App\Http\Controllers\Others\DocumentsController as OthersDocumentsController;
use App\Http\Controllers\Others\PictureController as OthersPictureController;
use App\Http\Controllers\Others\VideoController as OthersVideoController;
use App\Http\Controllers\Others\LifeRememberedController as OthersLifeRememberedController;
use App\Http\Controllers\Others\LifeRememberedVideoController as OthersLifeRememberedVideoController;
use App\Http\Controllers\Others\AdvisorsController as OthersAdvisorsController;
use App\Http\Controllers\Others\ExecutorsController as OthersExecutorsController;
use App\Http\Controllers\Others\OrgansDonationController as OthersOrgansDonationController;
use App\Http\Controllers\Others\VoiceNotesController as OthersVoiceNotesController;
use App\Http\Controllers\Others\MessagesController as OthersMessagesController;
use App\Http\Controllers\Others\ReviewController as OthersReviewController;
use App\Http\Controllers\Others\WithdrawalController as OthersWithdrawalController;

use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\PartnerRegistationController;
use App\Models\User;

Route::get('two-factor', [TwoFactorController::class, 'index'])->name('two-factor.index');
Route::post('two-factor', [TwoFactorController::class, 'verify'])->name('two-factor.verify');


Route::get('partner-registration', [PartnerRegistationController::class, 'index'])->name('partner-registration.index');
Route::post('partner-registration', [PartnerRegistationController::class, 'store'])->name('partner-registration.store');

Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe')->name('stripe');
    Route::get('stripe_mobile', 'stripe_mobile')->name('stripe_mobile');
    Route::post('stripe', 'stripePost')->name('stripe.post');
    Route::post('stripe/resubscribe', 'resubscribe')->name('stripe.resubscribe');
    Route::get('stripe/success', 'success')->name('stripe.success');
    Route::get('stripe/resubscribesuccess', 'resubscribesuccess')->name('stripe.resubscribesuccess');
    Route::post('subscription/cancel', 'cancelSubscription')->name('subscription.cancel');
});

Route::controller(PayPalController::class)->group(function () {
    Route::get('paypal', 'paypal')->name('paypal');
    Route::get('paypal_mobile', 'paypal_mobile')->name('paypal_mobile');
    Route::post('paypal', 'paypalPost')->name('paypal.post');
    Route::post('paypal/resubscribe', 'resubscribe')->name('paypal.resubscribe');
    Route::get('paypal/success', 'success')->name('paypal.success');
    Route::get('paypal/cancel', 'cancel')->name('paypal.cancel');
    Route::get('paypal/resubscribesuccess', 'resubscribesuccess')->name('paypal.resubscribesuccess');
    Route::post('paypal-subscription/cancel', 'cancelSubscription')->name('paypal.subscription.cancel');
});


Route::post('/contact-submit', [ContactController::class, 'Contactform'])->name('contact.submit');
Route::post('/partner-submit', [ContactController::class, 'PartnerWithUs'])->name('partner.submit');


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/partner_registration', function (\Illuminate\Http\Request $request) {
    $couponCode = $request->query('coupon_code');
    $assignedTo = $request->query('assigned_to'); // optional
    return view('affiliate_link', compact('couponCode', 'assignedTo'));
})->name('partner_registration');



Route::get('/cookies', function () {
    return view('cookies');
})->name('cookies');

Route::get('/terms_of_use', function () {
    return view('terms_of_use');
})->name('terms_of_use');

Route::get('/privacy_policy', function () {
    return view('privacy_policy');
})->name('privacy_policy');

Route::get('/cancellation_policy', function () {
    return view('cancellation_policy');
})->name('cancellation_policy');

Route::get('/pricing_policy', function () {
    return view('pricing_policy');
})->name('pricing_policy');





Route::get('/lpa/create/{id}', [LPAControllerMobile::class, 'create']);
Route::post('lpa/store', [LPAControllerMobile::class, 'store'])->name('lpa.store');

Route::get('/wills/create/{id}', [WillControllerMobile::class, 'create']);
Route::post('wills/store', [WillControllerMobile::class, 'store'])->name('wills.store');


Auth::routes();


Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->hasRole('executor')) {
        return redirect()->route('executor.dashboard');
    } elseif (Auth::user()->hasRole('customer')) {
        return redirect()->route('customer.dashboard');
    } elseif (Auth::user()->hasRole('partner')) {
        return redirect()->route('partner.dashboard');
    } else {
        return redirect()->route('dashboard');
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

    // Partner Management
    Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
    Route::get('/partners/create', [PartnerController::class, 'create'])->name('partners.create');
    Route::get('/partners/send_invite', [PartnerController::class, 'send_invite'])->name('partners.send_invite');
    Route::post('/partners/store', [PartnerController::class, 'store'])->name('partners.store');
    Route::post('/partners', [PartnerController::class, 'send_invite_email'])->name('partners.send_invite_email');
    Route::get('/partners/{id}/edit', [PartnerController::class, 'edit'])->name('partners.edit');
    Route::get('/partners/{id}/view_refferals', [PartnerController::class, 'view_refferals'])->name('partners.view_refferals');
    Route::put('/partners/{id}', [PartnerController::class, 'update'])->name('partners.update');
    Route::delete('/partners/{id}', [PartnerController::class, 'destroy'])->name('partners.destroy');

    // Admin Withdrawal Management
    Route::get('/withdraw', [AdminWithdrawalController::class, 'index'])->name('withdraw.index');
    Route::patch('/withdraw/{id}', [AdminWithdrawalController::class, 'update'])->name('withdraw.update');

    // Notifications
    Route::get('notifications/create', [AdminNotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications/send', [AdminNotificationController::class, 'send'])->name('notifications.send');

    // EMAILS
    Route::get('emails/create', [AdminEmailController::class, 'create'])->name('emails.create');
    Route::post('emails/send', [AdminEmailController::class, 'send'])->name('emails.send');
});

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // New routes for document reminders
    Route::post('/dashboard/update-reminder', [CustomerDashboardController::class, 'updateDocumentReminder'])->name('dashboard.update-reminder');
    Route::post('/dashboard/store-location', [CustomerDashboardController::class, 'storeDocumentLocation'])->name('dashboard.store-location');
    Route::post('/dashboard/update-location/{id}', [CustomerDashboardController::class, 'updateLocation'])->name('dashboard.update-location');
    Route::delete('delete-location/{id}', [CustomerDashboardController::class, 'deleteLocation'])->name('dashboard.delete-location');

    // LPA
    Route::get('lpa', [LPAController::class, 'index'])->name('lpa.index');
    Route::get('lpa/create', [LPAController::class, 'create'])->name('lpa.create');
    Route::post('lpa/store', [LPAController::class, 'store'])->name('lpa.store');
    Route::delete('/lpa/destroy/{id}', [LPAController::class, 'destroy'])->name('lpa.destroy');

    // WILLS
    Route::get('wills', [WillController::class, 'index'])->name('wills.index');
    Route::get('wills/create', [WillController::class, 'create'])->name('wills.create');
    Route::post('wills/store', [WillController::class, 'store'])->name('wills.store');
    Route::delete('/wills/destroy/{id}', [WillController::class, 'destroy'])->name('wills.destroy');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Assign Permission
    Route::get('/assign-permissions', [PermissionController::class, 'showAssignPermissionsForm'])->name('assign_permissions_form');
    Route::post('/assign-permissions', [PermissionController::class, 'assignPermissions'])->name('assign_permissions');

    // Customer Profile
    Route::get('/edit-profile', [CustomerSettingController::class, 'editProfile'])->name('edit_profile');
    Route::post('/update-profile', [CustomerSettingController::class, 'updateProfile'])->name('update_profile');
    Route::post('/update-profile-image', [CustomerSettingController::class, 'updateProfileImage'])->name('update_profile_image');
    Route::post('/update-password', [CustomerSettingController::class, 'updatePassword'])->name('update_password');

    // Customer Life Remembered
    Route::get('/life_remembered/view', [LifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::post('/life_remembered/store', [LifeRememberedController::class, 'store'])->name('life_remembered.store');
    Route::get('/life_remembered/{id}/media', [LifeRememberedController::class, 'getMedia']);
    Route::delete('/life_remembered/media/{id}', [LifeRememberedController::class, 'deleteMedia']);
    Route::post('/life_remembered/update', [LifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::post('/life_remembered/update/{id}', [LifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::delete('/life_remembered/destroy/{id}', [LifeRememberedController::class, 'destroy'])->name('life_remembered.destroy');

    // Customer Life Remembered Videos
    Route::get('/life_remembered_videos/view', [LifeRememberedVideoController::class, 'view'])->name('life_remembered_videos.view');
    Route::post('/life_remembered_videos/store', [LifeRememberedVideoController::class, 'store'])->name('life_remembered_videos.store');
    Route::get('/life_remembered_videos/{id}/media', [LifeRememberedVideoController::class, 'getMedia']);
    Route::delete('/life_remembered_videos/media/{id}', [LifeRememberedVideoController::class, 'deleteMedia']);
    Route::post('/life_remembered_videos/update/{id}', [LifeRememberedVideoController::class, 'update'])->name('life_remembered_videos.update');
    Route::delete('/life_remembered_videos/destroy/{id}', [LifeRememberedVideoController::class, 'destroy'])->name('life_remembered_videos.destroy');

    // Customer Wishes
    Route::get('/wishes/view', [WishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/store', [WishesController::class, 'store'])->name('wishes.store');
    Route::get('/wishes/{id}/media', [WishesController::class, 'getMedia']);
    Route::delete('/wishes/media/{id}', [WishesController::class, 'deleteMedia']);
    Route::post('/wishes/update', [WishesController::class, 'update'])->name('wishes.update');
    Route::post('/wishes/update/{id}', [WishesController::class, 'update'])->name('wishes.update');
    Route::delete('/wishes/destroy/{id}', [WishesController::class, 'destroy'])->name('wishes.destroy');

    // Customer Memorandum wishes
    Route::get('/memorandum_wishes/view', [MemorandumWishController::class, 'view'])->name('memorandum_wishes.view');
    Route::post('/memorandum_wishes/store', [MemorandumWishController::class, 'store'])->name('memorandum_wishes.store');
    Route::get('/memorandum_wishes/{id}/media', [MemorandumWishController::class, 'getMedia']);
    Route::delete('/memorandum_wishes/media/{id}', [MemorandumWishController::class, 'deleteMedia']);
    Route::post('/memorandum_wishes/update', [MemorandumWishController::class, 'update'])->name('memorandum_wishes.update');
    Route::post('/memorandum_wishes/update/{id}', [MemorandumWishController::class, 'update'])->name('memorandum_wishes.update');
    Route::delete('/memorandum_wishes/destroy/{id}', [MemorandumWishController::class, 'destroy'])->name('memorandum_wishes.destroy');

    // Customer Withdraw
    Route::get('/withdraw', [WithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [WithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [WithdrawalController::class, 'history'])->name('withdraw.history');

    // Customer Guidance
    Route::get('/guidance/view', [GuidanceController::class, 'view'])->name('guidance.view');
    Route::post('/guidance/store', [GuidanceController::class, 'store'])->name('guidance.store');
    Route::get('/guidance/{id}/media', [GuidanceController::class, 'getMedia']);
    Route::delete('/guidance/media/{id}', [GuidanceController::class, 'deleteMedia']);
    Route::post('/guidance/update', [GuidanceController::class, 'update'])->name('guidance.update');
    Route::post('/guidance/update/{id}', [GuidanceController::class, 'update'])->name('guidance.update');
    Route::delete('/guidance/destroy/{id}', [GuidanceController::class, 'destroy'])->name('guidance.destroy');

    // Custom Documents Type
    Route::post('/documents/save_custom_type', [DocumentsController::class, 'saveCustomType'])->name('documents.save_custom_type');
    // Customer Documents
    Route::get('/documents/view', [DocumentsController::class, 'view'])->name('documents.view');
    Route::post('/documents/store', [DocumentsController::class, 'store'])->name('documents.store');
    Route::post('/documents/update/{id}', [DocumentsController::class, 'update'])->name('documents.update');
    Route::delete('/documents/destroy/{id}', [DocumentsController::class, 'destroy'])->name('documents.destroy');

    // Custom Funeral Plan Types
    Route::post('/funeral_plans/save_custom_type', [FuneralPlanController::class, 'saveCustomType'])->name('funeral_plans.save_custom_type');
    // Customer Funeral Plans
    Route::get('/funeral_plans/view', [FuneralPlanController::class, 'view'])->name('funeral_plans.view');
    Route::post('/funeral_plans/store', [FuneralPlanController::class, 'store'])->name('funeral_plans.store');
    Route::post('/funeral_plans/update/{id}', [FuneralPlanController::class, 'update'])->name('funeral_plans.update');
    Route::delete('/funeral_plans/destroy/{id}', [FuneralPlanController::class, 'destroy'])->name('funeral_plans.destroy');

    // PICTURES & VIDEOS CONTROLLER
    Route::get('/pictures_and_videos/view', [PicturesAndVideosController::class, 'view'])->name('pictures_and_videos.view');
    Route::post('/pictures_and_videos/store', [PicturesAndVideosController::class, 'store'])->name('pictures_and_videos.store');
    Route::post('/pictures_and_videos/update/{id}', [PicturesAndVideosController::class, 'update'])->name('pictures_and_videos.update');
    Route::delete('/pictures_and_videos/destroy/{id}', [PicturesAndVideosController::class, 'destroy'])->name('pictures_and_videos.destroy');

    // PICTURES CONTROLLER
    Route::get('/pictures/view', [PictureController::class, 'view'])->name('pictures.view');
    Route::post('/pictures/store', [PictureController::class, 'store'])->name('pictures.store');
    Route::post('/pictures/update/{id}', [PictureController::class, 'update'])->name('pictures.update');
    Route::delete('/pictures/destroy/{id}', [PictureController::class, 'destroy'])->name('pictures.destroy');

    // VIDEOS CONTROLLER
    Route::get('/videos/view', [VideoController::class, 'view'])->name('videos.view');
    Route::post('/videos/store', [VideoController::class, 'store'])->name('videos.store');
    Route::post('/videos/update/{id}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/destroy/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');

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

    // Custom Bank Type
    Route::post('/bank_accounts/save_custom_type', [BankAccountController::class, 'saveCustomType'])->name('bank_accounts.save_custom_type');

    // Customer Bank
    Route::get('/bank_accounts/view', [BankAccountController::class, 'view'])->name('bank_accounts.view');
    Route::post('/bank_accounts/store', [BankAccountController::class, 'store'])->name('bank_accounts.store');
    Route::post('/bank_accounts/update/{id}', [BankAccountController::class, 'update'])->name('bank_accounts.update');
    Route::delete('/bank_accounts/destroy/{id}', [BankAccountController::class, 'destroy'])->name('bank_accounts.destroy');

    // Custom Investment Types
    Route::post('/investment_accounts/save_custom_type', [InvestmentAccountController::class, 'saveCustomType'])->name('investment_accounts.save_custom_type');
    // Customer Savings
    Route::get('/investment_accounts/view', [InvestmentAccountController::class, 'index'])->name('investment_accounts.view');
    Route::post('/investment_accounts/store', [InvestmentAccountController::class, 'store'])->name('investment_accounts.store');
    Route::post('/investment_accounts/update/{id}', [InvestmentAccountController::class, 'update'])->name('investment_accounts.update');
    Route::delete('/investment_accounts/destroy/{id}', [InvestmentAccountController::class, 'destroy'])->name('investment_accounts.destroy');

    // Custom Property Type
    Route::post('/properties/save_custom_type', [PropertyController::class, 'saveCustomType'])->name('properties.save_custom_type');
    // Customer Property (ies) Owned
    Route::get('/properties/view', [PropertyController::class, 'view'])->name('properties.view');
    Route::post('/properties/store', [PropertyController::class, 'store'])->name('properties.store');
    Route::put('/properties/update/{id}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');

    //Customer Custom Chattels
    Route::post('/personal_chattels/save_custom_type', [PersonalChattelController::class, 'saveCustomType'])->name('personal_chattels.save_custom_type');

    // Customer Chattels
    Route::get('/personal_chattels/view', [PersonalChattelController::class, 'view'])->name('personal_chattels.view');
    Route::post('/personal_chattels/store', [PersonalChattelController::class, 'store'])->name('personal_chattels.store');
    Route::post('/personal_chattels/update/{id}', [PersonalChattelController::class, 'update'])->name('personal_chattels.update');
    Route::delete('/personal_chattels/destroy/{id}', [PersonalChattelController::class, 'destroy'])->name('personal_chattels.destroy');

    // Custom Business Types
    Route::post('/business_interests/save_custom_type', [BusinessInterestController::class, 'saveCustomType'])->name('business_interests.save_custom_type');
    // Customer Business interests
    Route::get('/business_interests/view', [BusinessInterestController::class, 'view'])->name('business_interests.view');
    Route::post('/business_interests/store', [BusinessInterestController::class, 'store'])->name('business_interests.store');
    Route::post('/business_interests/update/{id}', [BusinessInterestController::class, 'update'])->name('business_interests.update');
    Route::delete('/business_interests/destroy/{id}', [BusinessInterestController::class, 'destroy'])->name('business_interests.destroy');

    // Custom Insurance Type
    Route::post('/insurance_policies/save_custom_type', [InsurancePolicyController::class, 'saveCustomType'])->name('insurance_policies.save_custom_type');
    // Customer Insurance Policies
    Route::get('/insurance_policies/view', [InsurancePolicyController::class, 'view'])->name('insurance_policies.view');
    Route::post('/insurance_policies/store', [InsurancePolicyController::class, 'store'])->name('insurance_policies.store');
    Route::post('/insurance_policies/update/{id}', [InsurancePolicyController::class, 'update'])->name('insurance_policies.update');
    Route::delete('/insurance_policies/destroy/{id}', [InsurancePolicyController::class, 'destroy'])->name('insurance_policies.destroy');

    // Custom Debt Type
    Route::post('/debt_and_liabilities/save_custom_type', [DebtAndLiabilityController::class, 'saveCustomType'])->name('debt_and_liabilities.save_custom_type');
    // Customer Debt & Liability
    Route::get('/debt_and_liabilities/view', [DebtAndLiabilityController::class, 'view'])->name('debt_and_liabilities.view');
    Route::post('/debt_and_liabilities/store', [DebtAndLiabilityController::class, 'store'])->name('debt_and_liabilities.store');
    Route::post('/debt_and_liabilities/update/{id}', [DebtAndLiabilityController::class, 'update'])->name('debt_and_liabilities.update');
    Route::delete('/debt_and_liabilities/destroy/{id}', [DebtAndLiabilityController::class, 'destroy'])->name('debt_and_liabilities.destroy');

    // Custom Digital Assets Type
    Route::post('/digital_assets/save_custom_type', [DigitalAssetController::class, 'saveCustomType'])->name('digital_assets.save_custom_type');
    // Customer Digital Assets
    Route::get('/digital_assets/view', [DigitalAssetController::class, 'view'])->name('digital_assets.view');
    Route::post('/digital_assets/store', [DigitalAssetController::class, 'store'])->name('digital_assets.store');
    Route::post('/digital_assets/update/{id}', [DigitalAssetController::class, 'update'])->name('digital_assets.update');
    Route::delete('/digital_assets/destroy/{id}', [DigitalAssetController::class, 'destroy'])->name('digital_assets.destroy');

    // Custom Intellectual Property Types
    Route::post('/intellectual_properties/save_custom_type', [IntellectualPropertyController::class, 'saveCustomType'])->name('intellectual_properties.save_custom_type');
    // Customer Intellectual Property
    Route::get('/intellectual_properties/view', [IntellectualPropertyController::class, 'view'])->name('intellectual_properties.view');
    Route::post('/intellectual_properties/store', [IntellectualPropertyController::class, 'store'])->name('intellectual_properties.store');
    Route::post('/intellectual_properties/update/{id}', [IntellectualPropertyController::class, 'update'])->name('intellectual_properties.update');
    Route::delete('/intellectual_properties/destroy/{id}', [IntellectualPropertyController::class, 'destroy'])->name('intellectual_properties.destroy');

    // Custom Other Asset Type
    Route::post('/other_assets/save_custom_type', [OtherAssetController::class, 'saveCustomType'])->name('other_assets.save_custom_type');
    // Customer Other Assets
    Route::get('/other_assets/view', [OtherAssetController::class, 'view'])->name('other_assets.view');
    Route::post('/other_assets/store', [OtherAssetController::class, 'store'])->name('other_assets.store');
    Route::post('/other_assets/update/{id}', [OtherAssetController::class, 'update'])->name('other_assets.update');
    Route::delete('/other_assets/destroy/{id}', [OtherAssetController::class, 'destroy'])->name('other_assets.destroy');

    // Custom Other Type of Asset Type
    Route::post('/other_type_of_assets/save_custom_type', [OtherTypeofAssetController::class, 'saveCustomType'])->name('other_type_of_assets.save_custom_type');
    // Customer Other Type of Assets
    Route::get('/other_type_of_assets/view', [OtherTypeofAssetController::class, 'view'])->name('other_type_of_assets.view');
    Route::post('/other_type_of_assets/store', [OtherTypeofAssetController::class, 'store'])->name('other_type_of_assets.store');
    Route::post('/other_type_of_assets/update/{id}', [OtherTypeofAssetController::class, 'update'])->name('other_type_of_assets.update');
    Route::delete('/other_type_of_assets/destroy/{id}', [OtherTypeofAssetController::class, 'destroy'])->name('other_type_of_assets.destroy');

    // Custom Foreign Asset Type
    Route::post('/foreign_assets/save_custom_type', [ForeignAssetsController::class, 'saveCustomType'])->name('foreign_assets.save_custom_type');
    // Customer Foreign Assets
    Route::get('/foreign_assets/view', [ForeignAssetsController::class, 'view'])->name('foreign_assets.view');
    Route::post('/foreign_assets/store', [ForeignAssetsController::class, 'store'])->name('foreign_assets.store');
    Route::post('/foreign_assets/update/{id}', [ForeignAssetsController::class, 'update'])->name('foreign_assets.update');
    Route::delete('/foreign_assets/destroy/{id}', [ForeignAssetsController::class, 'destroy'])->name('foreign_assets.destroy');

    // Customer pensions
    Route::get('/pension/view', [PensionController::class, 'view'])->name('pensions.view');
    Route::post('/pension/store', [PensionController::class, 'store'])->name('pensions.store');
    Route::post('/pension/update/{id}', [PensionController::class, 'update'])->name('pensions.update');
    Route::delete('/pension/destroy/{id}', [PensionController::class, 'destroy'])->name('pensions.destroy');

    // Organs Donation
    Route::get('/organs_donation/view', [OrgansDonationController::class, 'view'])->name('organs_donation.view');
    Route::post('/organs_donation/store', [OrgansDonationController::class, 'store'])->name('organs_donation.store');
    Route::post('/organs_donation/update/{id}', [OrgansDonationController::class, 'update'])->name('organs_donation.update');
    Route::delete('/organs_donation/destroy/{id}', [OrgansDonationController::class, 'destroy'])->name('organs_donation.destroy');

    // Voice Notes
    Route::get('/voice_notes/view', [VoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::post('/voice_notes/store', [VoiceNotesController::class, 'store'])->name('voice_notes.store');
    Route::delete('/voice_notes/destroy/{id}', [VoiceNotesController::class, 'destroy'])->name('voice_notes.destroy');

    // TASKS
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Messages
    Route::get('/messages/view', [MessagesController::class, 'index'])->name('messages.view');

    // Reviews
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


    // OPENAI
    Route::get('/openai/view', [OpenAIController::class, 'index'])->name('openai.view');
    Route::post('/openai/chat', [OpenAIController::class, 'chat'])->name('openai.chat');

    // Membership
    Route::get('/membership/membership', [MembershipController::class, 'index'])->name('membership.view');
    Route::get('/membership/checkout', [MembershipController::class, 'checkout_page'])->name('checkout.view');

    // Funeral Wake
    Route::get('/funeral_wake/view', [FuneralWakeController::class, 'view'])->name('funeral_wake.view');
    Route::post('/funeral_wake/store', [FuneralWakeController::class, 'store'])->name('funeral_wake.store');
    Route::post('/funeral_wake/update/{id}', [FuneralWakeController::class, 'update'])->name('funeral_wake.update');
    Route::delete('/funeral_wake/destroy/{id}', [FuneralWakeController::class, 'destroy'])->name('funeral_wake.destroy');
});


Route::middleware(['auth', 'role:partner'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');

    Route::post('/dashboard/update-reminder', [PartnerDashboardController::class, 'updateDocumentReminder'])->name('dashboard.update-reminder');
    Route::post('/dashboard/store-location', [PartnerDashboardController::class, 'storeDocumentLocation'])->name('dashboard.store-location');
    Route::post('/dashboard/update-location/{id}', [PartnerDashboardController::class, 'updateLocation'])->name('dashboard.update-location');
    Route::delete('/dashboard/delete-location/{id}', [PartnerDashboardController::class, 'deleteLocation'])->name('dashboard.delete-location');
    // LPA
    Route::get('lpa', [PartnerLPAController::class, 'index'])->name('lpa.index');
    Route::get('lpa/create', [PartnerLPAController::class, 'create'])->name('lpa.create');
    Route::post('lpa/store', action: [PartnerLPAController::class, 'store'])->name('lpa.store');
    Route::delete('/lpa/destroy/{id}', [PartnerLPAController::class, 'destroy'])->name('lpa.destroy');

    // WILLS
    Route::get('wills', [PartnerWillController::class, 'index'])->name('wills.index');
    Route::get('wills/create', [PartnerWillController::class, 'create'])->name('wills.create');
    Route::post('wills/store', action: [PartnerWillController::class, 'store'])->name('wills.store');
    Route::delete('/wills/destroy/{id}', [PartnerWillController::class, 'destroy'])->name('wills.destroy');

    // Assign Permission
    Route::get('/assign-permissions', [PartnerPermissionController::class, 'showAssignPermissionsForm'])->name('assign_permissions_form');
    Route::post('/assign-permissions', [PartnerPermissionController::class, 'assignPermissions'])->name('assign_permissions');

    // Notifications
    Route::get('notifications', [PartnerNotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/read/{id}', [PartnerNotificationController::class, 'markAsRead'])->name('notifications.read');

    // Customer Profile
    Route::get('/edit-profile', [PartnerSettingController::class, 'editProfile'])->name('edit_profile');
    Route::post('/update-profile', [PartnerSettingController::class, 'updateProfile'])->name('update_profile');
    Route::post('/update-profile-image', [PartnerSettingController::class, 'updateProfileImage'])->name('update_profile_image');
    Route::post('/update-password', [PartnerSettingController::class, 'updatePassword'])->name('update_password');

    // Partner Life Remembered
    Route::get('/life_remembered/view', [PartnerLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::post('/life_remembered/store', [PartnerLifeRememberedController::class, 'store'])->name('life_remembered.store');
    Route::get('/life_remembered/{id}/media', [PartnerLifeRememberedController::class, 'getMedia']);
    Route::delete('/life_remembered/media/{id}', [PartnerLifeRememberedController::class, 'deleteMedia']);
    Route::post('/life_remembered/update', [PartnerLifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::post('/life_remembered/update/{id}', [PartnerLifeRememberedController::class, 'update'])->name('life_remembered.update');
    Route::delete('/life_remembered/destroy/{id}', [PartnerLifeRememberedController::class, 'destroy'])->name('life_remembered.destroy');

    // Partner Life Remembered Videos
    Route::get('/life_remembered_videos/view', [PartnerLifeRememberedVideoController::class, 'view'])->name('life_remembered_videos.view');
    Route::post('/life_remembered_videos/store', [PartnerLifeRememberedVideoController::class, 'store'])->name('life_remembered_videos.store');
    Route::get('/life_remembered_videos/{id}/media', [PartnerLifeRememberedVideoController::class, 'getMedia']);
    Route::delete('/life_remembered_videos/media/{id}', [PartnerLifeRememberedVideoController::class, 'deleteMedia']);
    Route::post('/life_remembered_videos/update/{id}', [PartnerLifeRememberedVideoController::class, 'update'])->name('life_remembered_videos.update');
    Route::delete('/life_remembered_videos/destroy/{id}', [PartnerLifeRememberedVideoController::class, 'destroy'])->name('life_remembered_videos.destroy');

    // Partner Wishes
    Route::get('/wishes/view', [PartnerWishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/store', [PartnerWishesController::class, 'store'])->name('wishes.store');
    Route::get('/wishes/{id}/media', [PartnerWishesController::class, 'getMedia']);
    Route::delete('/wishes/media/{id}', [PartnerWishesController::class, 'deleteMedia']);
    Route::post('/wishes/update', [PartnerWishesController::class, 'update'])->name('wishes.update');
    Route::post('/wishes/update/{id}', [PartnerWishesController::class, 'update'])->name('wishes.update');
    Route::delete('/wishes/destroy/{id}', [PartnerWishesController::class, 'destroy'])->name('wishes.destroy');

    // Partner Memorandum Wishes
    Route::get('/memorandum_wishes/view', [PartnerMemorandumWishController::class, 'view'])->name('memorandum_wishes.view');
    Route::post('/memorandum_wishes/store', [PartnerMemorandumWishController::class, 'store'])->name('memorandum_wishes.store');
    Route::get('/memorandum_wishes/{id}/media', [PartnerMemorandumWishController::class, 'getMedia']);
    Route::delete('/memorandum_wishes/media/{id}', [PartnerMemorandumWishController::class, 'deleteMedia']);
    Route::post('/memorandum_wishes/update', [PartnerMemorandumWishController::class, 'update'])->name('memorandum_wishes.update');
    Route::post('/memorandum_wishes/update/{id}', [PartnerMemorandumWishController::class, 'update'])->name('memorandum_wishes.update');
    Route::delete('/memorandum_wishes/destroy/{id}', [PartnerMemorandumWishController::class, 'destroy'])->name('memorandum_wishes.destroy');

    // Partner Withdraw
    Route::get('/withdraw', [PartnerWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [PartnerWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [PartnerWithdrawalController::class, 'history'])->name('withdraw.history');

    // Partner Guidance
    Route::get('/guidance/view', [PartnerGuidanceController::class, 'view'])->name('guidance.view');
    Route::post('/guidance/store', [PartnerGuidanceController::class, 'store'])->name('guidance.store');
    Route::get('/guidance/{id}/media', [PartnerGuidanceController::class, 'getMedia']);
    Route::delete('/guidance/media/{id}', [PartnerGuidanceController::class, 'deleteMedia']);
    Route::post('/guidance/update', [PartnerGuidanceController::class, 'update'])->name('guidance.update');
    Route::post('/guidance/update/{id}', [PartnerGuidanceController::class, 'update'])->name('guidance.update');
    Route::delete('/guidance/destroy/{id}', [PartnerGuidanceController::class, 'destroy'])->name('guidance.destroy');

    // Partner Documents Type
    Route::post('/documents/save_custom_type', [PartnerDocumentsController::class, 'saveCustomType'])->name('documents.save_custom_type');
    // Partner Documents
    Route::get('/documents/view', [PartnerDocumentsController::class, 'view'])->name('documents.view');
    Route::post('/documents/store', [PartnerDocumentsController::class, 'store'])->name('documents.store');
    Route::post('/documents/update/{id}', [PartnerDocumentsController::class, 'update'])->name('documents.update');
    Route::delete('/documents/destroy/{id}', [PartnerDocumentsController::class, 'destroy'])->name('documents.destroy');

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

    // Custom Bank Type
    Route::post('/bank_accounts/save_custom_type', [PartnerBankAccountController::class, 'saveCustomType'])->name('bank_accounts.save_custom_type');

    // Customer Bank
    Route::get('/bank_accounts/view', [PartnerBankAccountController::class, 'view'])->name('bank_accounts.view');
    Route::post('/bank_accounts/store', [PartnerBankAccountController::class, 'store'])->name('bank_accounts.store');
    Route::post('/bank_accounts/update/{id}', [PartnerBankAccountController::class, 'update'])->name('bank_accounts.update');
    Route::delete('/bank_accounts/destroy/{id}', [PartnerBankAccountController::class, 'destroy'])->name('bank_accounts.destroy');

    // Custom Investment Types
    Route::post('/investment_accounts/save_custom_type', [PartnerInvestmentAccountController::class, 'saveCustomType'])->name('investment_accounts.save_custom_type');
    // Customer Savings
    Route::get('/investment_accounts/view', [PartnerInvestmentAccountController::class, 'index'])->name('investment_accounts.view');
    Route::post('/investment_accounts/store', [PartnerInvestmentAccountController::class, 'store'])->name('investment_accounts.store');
    Route::post('/investment_accounts/update/{id}', [PartnerInvestmentAccountController::class, 'update'])->name('investment_accounts.update');
    Route::delete('/investment_accounts/destroy/{id}', [PartnerInvestmentAccountController::class, 'destroy'])->name('investment_accounts.destroy');

    // Custom Property Type
    Route::post('/properties/save_custom_type', [PartnerPropertyController::class, 'saveCustomType'])->name('properties.save_custom_type');
    // Customer Property (ies) Owned
    Route::get('/properties/view', [PartnerPropertyController::class, 'view'])->name('properties.view');
    Route::post('/properties/store', [PartnerPropertyController::class, 'store'])->name('properties.store');
    Route::put('/properties/update/{id}', [PartnerPropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{id}', [PartnerPropertyController::class, 'destroy'])->name('properties.destroy');

    //Customer Custom Chattels
    Route::post('/personal_chattels/save_custom_type', [PersonalChattelController::class, 'saveCustomType'])->name('personal_chattels.save_custom_type');

    // Customer Chattels
    Route::get('/personal_chattels/view', [PartnerPersonalChattelController::class, 'view'])->name('personal_chattels.view');
    Route::post('/personal_chattels/store', [PartnerPersonalChattelController::class, 'store'])->name('personal_chattels.store');
    Route::post('/personal_chattels/update/{id}', [PartnerPersonalChattelController::class, 'update'])->name('personal_chattels.update');
    Route::delete('/personal_chattels/destroy/{id}', [PartnerPersonalChattelController::class, 'destroy'])->name('personal_chattels.destroy');

    // Custom Business Types
    Route::post('/business_interests/save_custom_type', [PartnerBusinessInterestController::class, 'saveCustomType'])->name('business_interests.save_custom_type');
    // Customer Business interests
    Route::get('/business_interests/view', [PartnerBusinessInterestController::class, 'view'])->name('business_interests.view');
    Route::post('/business_interests/store', [PartnerBusinessInterestController::class, 'store'])->name('business_interests.store');
    Route::post('/business_interests/update/{id}', [PartnerBusinessInterestController::class, 'update'])->name('business_interests.update');
    Route::delete('/business_interests/destroy/{id}', [PartnerBusinessInterestController::class, 'destroy'])->name('business_interests.destroy');

    // Custom Insurance Type
    Route::post('/insurance_policies/save_custom_type', [PartnerInsurancePolicyController::class, 'saveCustomType'])->name('insurance_policies.save_custom_type');
    // Customer Insurance Policies
    Route::get('/insurance_policies/view', [PartnerInsurancePolicyController::class, 'view'])->name('insurance_policies.view');
    Route::post('/insurance_policies/store', [PartnerInsurancePolicyController::class, 'store'])->name('insurance_policies.store');
    Route::post('/insurance_policies/update/{id}', [PartnerInsurancePolicyController::class, 'update'])->name('insurance_policies.update');
    Route::delete('/insurance_policies/destroy/{id}', [PartnerInsurancePolicyController::class, 'destroy'])->name('insurance_policies.destroy');

    // Custom Debt Type
    Route::post('/debt_and_liabilities/save_custom_type', [PartnerDebtAndLiabilityController::class, 'saveCustomType'])->name('debt_and_liabilities.save_custom_type');
    // Customer Debt & Liability
    Route::get('/debt_and_liabilities/view', [PartnerDebtAndLiabilityController::class, 'view'])->name('debt_and_liabilities.view');
    Route::post('/debt_and_liabilities/store', [PartnerDebtAndLiabilityController::class, 'store'])->name('debt_and_liabilities.store');
    Route::post('/debt_and_liabilities/update/{id}', [PartnerDebtAndLiabilityController::class, 'update'])->name('debt_and_liabilities.update');
    Route::delete('/debt_and_liabilities/destroy/{id}', [PartnerDebtAndLiabilityController::class, 'destroy'])->name('debt_and_liabilities.destroy');

    // Custom Digital Assets Type
    Route::post('/digital_assets/save_custom_type', [PartnerDigitalAssetController::class, 'saveCustomType'])->name('digital_assets.save_custom_type');
    // Customer Digital Assets
    Route::get('/digital_assets/view', [PartnerDigitalAssetController::class, 'view'])->name('digital_assets.view');
    Route::post('/digital_assets/store', [PartnerDigitalAssetController::class, 'store'])->name('digital_assets.store');
    Route::post('/digital_assets/update/{id}', [PartnerDigitalAssetController::class, 'update'])->name('digital_assets.update');
    Route::delete('/digital_assets/destroy/{id}', [PartnerDigitalAssetController::class, 'destroy'])->name('digital_assets.destroy');

    // Custom Intellectual Property Types
    Route::post('/intellectual_properties/save_custom_type', [PartnerIntellectualPropertyController::class, 'saveCustomType'])->name('intellectual_properties.save_custom_type');
    // Customer Intellectual Property
    Route::get('/intellectual_properties/view', [PartnerIntellectualPropertyController::class, 'view'])->name('intellectual_properties.view');
    Route::post('/intellectual_properties/store', [PartnerIntellectualPropertyController::class, 'store'])->name('intellectual_properties.store');
    Route::post('/intellectual_properties/update/{id}', [PartnerIntellectualPropertyController::class, 'update'])->name('intellectual_properties.update');
    Route::delete('/intellectual_properties/destroy/{id}', [PartnerIntellectualPropertyController::class, 'destroy'])->name('intellectual_properties.destroy');

    // Custom Other Asset Type
    Route::post('/other_assets/save_custom_type', [PartnerOtherAssetController::class, 'saveCustomType'])->name('other_assets.save_custom_type');
    // Customer Other Assets
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

    // Organs Donation
    Route::get('/organs_donation/view', [PartnerOrgansDonationController::class, 'view'])->name('organs_donation.view');
    Route::post('/organs_donation/store', [PartnerOrgansDonationController::class, 'store'])->name('organs_donation.store');
    Route::post('/organs_donation/update/{id}', [PartnerOrgansDonationController::class, 'update'])->name('organs_donation.update');
    Route::delete('/organs_donation/destroy/{id}', [PartnerOrgansDonationController::class, 'destroy'])->name('organs_donation.destroy');

    // Voice Notes
    Route::get('/voice_notes/view', [PartnerVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::post('/voice_notes/store', [PartnerVoiceNotesController::class, 'store'])->name('voice_notes.store');
    Route::delete('/voice_notes/destroy/{id}', [PartnerVoiceNotesController::class, 'destroy'])->name('voice_notes.destroy');

    // Messages
    Route::get('/messages/view', [PartnerMessagesController::class, 'index'])->name('messages.view');

    // Reviews
    Route::post('reviews', [PartnerReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [PartnerReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [PartnerReviewController::class, 'destroy'])->name('reviews.destroy');

    // TASK
    Route::get('tasks', [PartnerTaskController::class, 'index'])->name('tasks.index');
    Route::post('tasks', [PartnerTaskController::class, 'store'])->name('tasks.store');
    Route::put('tasks/{id}', [PartnerTaskController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{id}', [PartnerTaskController::class, 'destroy'])->name('tasks.destroy');

    // OPENAI
    Route::get('/openai/view', [PartnerOpenAIController::class, 'index'])->name('openai.view');
    Route::post('/openai/chat', [PartnerOpenAIController::class, 'chat'])->name('openai.chat');

    // Membership
    Route::get('/membership/membership', [PartnerMembershipController::class, 'index'])->name('membership.view');
    Route::get('/membership/checkout', [PartnerMembershipController::class, 'checkout_page'])->name('checkout.view');

    // WILL GENERATOR
    Route::get('will_generator', [PartnerWillGeneratorController::class, 'index'])->name('will_generator.index');
    Route::get('will_generator/create', [PartnerWillGeneratorController::class, 'create'])->name('will_generator.create');
    Route::get('will_generator/about_you', [PartnerWillGeneratorController::class, 'about_you'])->name('will_generator.about_you');
    Route::get('will_generator/step4', [PartnerWillGeneratorController::class, 'step4'])->name('will_generator.step4');
    Route::post('will_generator/step4', [PartnerWillGeneratorController::class, 'store_step4'])->name('will_generator.store_step4');
    Route::get('will_generator/step5', [PartnerWillGeneratorController::class, 'step5'])->name('will_generator.step5');
    Route::post('will_generator/step5', [PartnerWillGeneratorController::class, 'store_step5'])->name('will_generator.store_step5');
    Route::post('will_generator/about_you', [PartnerWillGeneratorController::class, 'store_about_you'])->name('will_generator.store_about_you');
    Route::post('will_generator/user_child/store', [PartnerWillGeneratorController::class, 'store_user_child'])->name('will_generator.user_child.store');
    Route::post('will_generator/user_child/edit', [PartnerWillGeneratorController::class, 'edit_user_child'])->name('will_generator.user_child.edit');
    Route::post('will_generator/user_child/delete', [PartnerWillGeneratorController::class, 'delete_user_child'])->name('will_generator.user_child.delete');
    Route::post('will_generator/user_pet/store', [PartnerWillGeneratorController::class, 'store_user_pet'])->name('will_generator.user_pet.store');
    Route::post('will_generator/user_pet/edit', [PartnerWillGeneratorController::class, 'edit_user_pet'])->name('will_generator.user_pet.edit');
    Route::post('will_generator/user_pet/delete', [PartnerWillGeneratorController::class, 'delete_user_pet'])->name('will_generator.user_pet.delete');

    Route::get('will_generator/account_properties', [PartnerWillGeneratorController::class, 'account_properties'])->name('will_generator.account_properties');
    Route::post('will_generator/account_properties', [PartnerWillGeneratorController::class, 'submit_account_properties'])->name('will_generator.account_properties');
    Route::post('will_generator/account_properties/store', [PartnerWillGeneratorController::class, 'store_account_properties'])->name('will_generator.account_properties.store');
    Route::put('will_generator/account_properties/update', [PartnerWillGeneratorController::class, 'update_account_properties'])->name('will_generator.account_properties.update');
    Route::delete('will_generator/account_properties/delete/{id}', [PartnerWillGeneratorController::class, 'delete_account_properties'])->name('will_generator.account_properties.delete');

    Route::get('will_generator/executor', [PartnerWillGeneratorController::class, 'executor'])->name('will_generator.executor');
    Route::get('will_generator/executor/step2', [PartnerWillGeneratorController::class, 'executor_step2'])->name('will_generator.executor_step2');
    Route::get('will_generator/executor/step3', [PartnerWillGeneratorController::class, 'executor_step3'])->name('will_generator.executor_step3');
    Route::get('will_generator/executor/family_friend', [PartnerWillGeneratorController::class, 'family_friend'])->name('will_generator.family_friend');
    Route::post('will_generator/executor/get_executor_step3', [PartnerWillGeneratorController::class, 'get_executor_step3'])->name('will_generator.get_executor_step3');
    Route::post('will_generator/executor/store_family_friend', [PartnerWillGeneratorController::class, 'store_family_friend'])->name('will_generator.store_family_friend');
    Route::get('will_generator/executor/farewill_trustees', [PartnerWillGeneratorController::class, 'farewill_trustees'])->name('will_generator.farewill_trustees');

    Route::get('will_generator/estates',[PartnerWillGeneratorController::class,'your_estate'])->name('will_generator.estates');
    Route::get('will_generator/choose_inherited_persons',[PartnerWillGeneratorController::class,'choose_inherited_persons'])->name('will_generator.choose_inherited_persons');
    Route::get('will_generator/choose_inherited_charity',[PartnerWillGeneratorController::class,'choose_inherited_charity'])->name('will_generator.choose_inherited_charity');
    Route::post('will_generator/process_inherited_charity',[PartnerWillGeneratorController::class,'process_inherited_charity'])->name('will_generator.process_inherited_charity');
    Route::get('will_generator/share_percentage',[PartnerWillGeneratorController::class,'share_percentage'])->name('will_generator.share_percentage');
    Route::get('will_generator/gift',[PartnerWillGeneratorController::class,'gift'])->name('will_generator.gift');
    Route::get('will_generator/gift/add/{type}',[PartnerWillGeneratorController::class,'show_add_gift'])->name('will_generator.gift.add');
    Route::post('will_generator/gift/store_add_gift',[PartnerWillGeneratorController::class,'store_add_gift'])->name('will_generator.gift.store_add_gift');


});

// Executors  Routes
Route::middleware(['auth', 'role:executor'])->prefix('executor')->name('executor.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ExecutorDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-todo', [ExecutorDashboardController::class, 'updateTodoStatus'])->name('dashboard.update-todo');

    // Reviews
    Route::post('reviews', [ExecutorReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [ExecutorReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [ExecutorReviewController::class, 'destroy'])->name('reviews.destroy');

    // Customer Withdraw
    Route::get('/withdraw', [ExecutorWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [ExecutorWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [ExecutorWithdrawalController::class, 'history'])->name('withdraw.history');

    // LPA
    Route::get('lpa', [ExecutorLPAController::class, 'index'])->name('lpa.index');

    // WILLS
    Route::get('wills', [ExecutorWillController::class, 'index'])->name('wills.index');

    // Executors View Routes
    Route::get('/life_remembered/view', [ExecutorLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::get('/life_remembered_videos/view', [ExecutorLifeRememberedVideoController::class, 'view'])->name('life_remembered_videos.view');
    Route::get('/wishes/view', [ExecutorWishesController::class, 'view'])->name('wishes.view');
    Route::get('/memorandum_wishes/view', [ExecutorMemorandumWishController::class, 'view'])->name('memorandum_wishes.view');
    Route::get('/guidance/view', [ExecutorGuidanceController::class, 'view'])->name('guidance.view');
    Route::get('/documents/view', [ExecutorDocumentsController::class, 'view'])->name('documents.view');
    Route::get('/pictures_and_videos/view', [ExecutorPicturesAndVideosController::class, 'view'])->name('pictures_and_videos.view');
    Route::get('/pictures/view', [ExecutorPictureController::class, 'view'])->name('pictures.view');
    Route::get('/videos/view', [ExecutorVideoController::class, 'view'])->name('videos.view');
    Route::get('/advisors/view', [ExecutorAdvisorsController::class, 'view'])->name('advisors.view');
    Route::get('/executors/view', [ExecutorExecutorsController::class, 'view'])->name('executors.view');
    Route::get('/bank_accounts/view', [ExecutorBankAccountController::class, 'view'])->name('bank_accounts.view');
    Route::get('/investment_accounts/view', [ExecutorInvestmentAccountController::class, 'index'])->name('investment_accounts.view');
    Route::get('/properties/view', [ExecutorPropertyController::class, 'view'])->name('properties.view');
    Route::get('/personal_chattels/view', [ExecutorPersonalChattelController::class, 'view'])->name('personal_chattels.view');
    Route::get('/business_interests/view', [ExecutorBusinessInterestController::class, 'view'])->name('business_interests.view');
    Route::get('/insurance_policies/view', [ExecutorInsurancePolicyController::class, 'view'])->name('insurance_policies.view');
    Route::get('/debt_and_liabilities/view', [ExecutorDebtAndLiabilityController::class, 'view'])->name('debt_and_liabilities.view');
    Route::get('/digital_assets/view', [ExecutorDigitalAssetController::class, 'view'])->name('digital_assets.view');
    Route::get('/intellectual_properties/view', [ExecutorIntellectualPropertyController::class, 'view'])->name('intellectual_properties.view');
    Route::get('/other_assets/view', [ExecutorOtherAssetController::class, 'view'])->name('other_assets.view');
    Route::get('/other_type_of_assets/view', [ExecutorOtherTypeOfAssetController::class, 'view'])->name('other_type_of_assets.view');
    Route::get('/pension/view', [ExecutorPensionController::class, 'view'])->name('pensions.view');
    Route::get('/funeral_plans/view', [ExecutorFuneralPlanController::class, 'view'])->name('funeral_plans.view');
    Route::get('/foreign_assets/view', [ExecutorForeignAssetsController::class, 'view'])->name('foreign_assets.view');
    Route::get('/organs_donation/view', [ExecutorOrgansDonationController::class, 'view'])->name('organs_donation.view');
    Route::get('/voice_notes/view', [ExecutorVoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::get('/funeral_wake/view', [ExecutorFuneralWakeController::class, 'view'])->name('funeral_wake.view');
    Route::get('tasks', [ExecutorTaskController::class, 'index'])->name('tasks.index');
    Route::get('/messages/view', [ExecutorMessagesController::class, 'index'])->name('messages.view');
});

// Others Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [OthersDashboardController::class, 'index'])->name('dashboard');

    Route::middleware("permission:view bank accounts")->group(function () {
        Route::get('/bank-accounts', [OthersBankAccountController::class, 'view'])->name('bank_accounts.view');
    });

    Route::middleware("permission:view investment accounts")->group(function () {
        Route::get('/investment-accounts', [OthersInvestmentAccountController::class, 'index'])->name('investment_accounts.view');
    });

    Route::middleware("permission:view properties")->group(function () {
        Route::get('/properties', [OthersPropertyController::class, 'view'])->name('properties.view');
    });

    Route::middleware("permission:view personal chattels")->group(function () {
        Route::get('/personal-chattels', [OthersPersonalChattelController::class, 'view'])->name('personal_chattels.view');
    });

    Route::middleware("permission:view business interests")->group(function () {
        Route::get('/business-interests', [OthersBusinessInterestController::class, 'view'])->name('business_interests.view');
    });

    Route::middleware("permission:view insurance policies")->group(function () {
        Route::get('/insurance-policies', [OthersInsurancePolicyController::class, 'view'])->name('insurance_policies.view');
    });

    Route::middleware("permission:view debt and liabilities")->group(function () {
        Route::get('/debt-and-liabilities', [OthersDebtAndLiabilityController::class, 'view'])->name('debt_and_liabilities.view');
    });

    Route::middleware("permission:view digital assets")->group(function () {
        Route::get('/digital-assets', [OthersDigitalAssetController::class, 'view'])->name('digital_assets.view');
    });

    Route::middleware("permission:view intellectual properties")->group(function () {
        Route::get('/intellectual-properties', [OthersIntellectualPropertyController::class, 'view'])->name('intellectual_properties.view');
    });

    Route::middleware("permission:view other assets")->group(function () {
        Route::get('/other-assets', [OthersOtherAssetController::class, 'view'])->name('other_assets.view');
    });

    Route::middleware("permission:view other type of assets")->group(function () {
        Route::get('/other-type-of-assets', [OthersOtherTypeOfAssetController::class, 'view'])->name('other_type_of_assets.view');
    });

    Route::middleware("permission:view pension")->group(function () {
        Route::get('/pension/view', [OthersPensionController::class, 'view'])->name('pensions.view');
    });

    Route::middleware("permission:view pension")->group(function () {
        Route::get('/foreign_assets/view', [OthersForeignAssetsController::class, 'view'])->name('foreign_assets.view');
    });


    Route::middleware("permission:view funeral plan")->group(function () {
        Route::get('/funeral_plans/view', [OthersFuneralPlanController::class, 'view'])->name('funeral_plans.view');
    });

    Route::middleware("permission:view pictures")->group(function () {
        Route::get('/pictures/view', [OthersPictureController::class, 'view'])->name('pictures.view');
    });

    Route::middleware("permission:view videos")->group(function () {
        Route::get('/videos/view', [OthersVideoController::class, 'view'])->name('videos.view');
    });

    Route::middleware("permission:view wishes")->group(function () {
        Route::get('/wishes', [OthersWishesController::class, 'view'])->name('wishes.view');
    });

    Route::middleware("permission:view memorandum wishes")->group(function () {
        Route::get('/memorandum_wishes', [OthersMemorandumWishController::class, 'view'])->name('memorandum_wishes.view');
    });

    Route::middleware("permission:view guidance")->group(function () {
        Route::get('/guidance', [OthersGuidanceController::class, 'view'])->name('guidance.view');
    });

    Route::middleware("permission:view life remembered")->group(function () {
        Route::get('/life_remembered_videos/view', [OthersLifeRememberedVideoController::class, 'view'])->name('life_remembered_videos.view');
        Route::get('/life-remembered', [OthersLifeRememberedController::class, 'view'])->name('life_remembered.view');
    });

    Route::middleware("permission:view advisors")->group(function () {
        Route::get('/advisors', [OthersAdvisorsController::class, 'view'])->name('advisors.view');
    });

    Route::middleware("permission:view executors")->group(function () {
        Route::get('/executors', [OthersExecutorsController::class, 'view'])->name('executors.view');
    });

    Route::middleware("permission:view organs donation")->group(function () {
        Route::get('/organs-donation', [OthersOrgansDonationController::class, 'view'])->name('organs_donation.view');
    });

    Route::middleware("permission:view voice notes")->group(function () {
        Route::get('/voice-notes', [OthersVoiceNotesController::class, 'view'])->name('voice_notes.view');
    });

    Route::middleware("permission:view documents")->group(function () {
        Route::get('/documents', [OthersDocumentsController::class, 'view'])->name('documents.view');
    });

    // message
    Route::get('/messages/view', [OthersMessagesController::class, 'index'])->name('messages.view');

    // Customer Withdraw
    Route::get('/withdraw', [OthersWithdrawalController::class, 'view'])->name('withdraw.view');
    Route::post('/withdraw/process', [OthersWithdrawalController::class, 'process'])->name('withdraw.process');
    Route::get('/withdraw/history', [OthersWithdrawalController::class, 'history'])->name('withdraw.history');

    // Reviews
    Route::post('reviews', [OthersReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [OthersReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [OthersReviewController::class, 'destroy'])->name('reviews.destroy');
});
