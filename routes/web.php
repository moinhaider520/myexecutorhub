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
use App\Http\Controllers\Customer\PropertyController;
use App\Http\Controllers\Customer\PersonalChattelController;
use App\Http\Controllers\Customer\PermissionController;
use App\Http\Controllers\Customer\BusinessInterestController;
use App\Http\Controllers\Customer\InsurancePolicyController;
use App\Http\Controllers\Customer\DebtAndLiabilityController;
use App\Http\Controllers\Customer\DigitalAssetController;
use App\Http\Controllers\Customer\IntellectualPropertyController;
use App\Http\Controllers\Customer\OtherAssetController;
use App\Http\Controllers\Customer\DocumentsController;
use App\Http\Controllers\Customer\WishesController;
use App\Http\Controllers\Customer\GuidanceController;
use App\Http\Controllers\Customer\LifeRememberedController;
use App\Http\Controllers\Customer\AdvisorsController;
use App\Http\Controllers\Customer\ExecutorsController;
use App\Http\Controllers\Customer\OrgansDonationController;
use App\Http\Controllers\Customer\VoiceNotesController;
use App\Http\Controllers\Customer\MessagesController;
use App\Http\Controllers\Customer\OpenAIController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\MembershipController;
// Role Executor Controller 
use App\Http\Controllers\Executor\DashboardController as ExecutorDashboardController;
use App\Http\Controllers\Executor\LifeRememberedController as ExecutorLifeRememberedController;
use App\Http\Controllers\Executor\WishesController as ExecutorWishesController;
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
use App\Http\Controllers\Executor\OrgansDonationController as ExecutorOrgansDonationController;
use App\Http\Controllers\Executor\VoiceNotesController as ExecutorVoiceNotesController;
use App\Http\Controllers\Executor\MessagesController as ExecutorMessagesController;
use App\Http\Controllers\Executor\ReviewController as ExecutorReviewController;

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
use App\Http\Controllers\Others\WishesController as OthersWishesController;
use App\Http\Controllers\Others\GuidanceController as OthersGuidanceController;
use App\Http\Controllers\Others\DocumentsController as OthersDocumentsController;
use App\Http\Controllers\Others\LifeRememberedController as OthersLifeRememberedController;
use App\Http\Controllers\Others\AdvisorsController as OthersAdvisorsController;
use App\Http\Controllers\Others\ExecutorsController as OthersExecutorsController;
use App\Http\Controllers\Others\OrgansDonationController as OthersOrgansDonationController;
use App\Http\Controllers\Others\VoiceNotesController as OthersVoiceNotesController;
use App\Http\Controllers\Others\MessagesController as OthersMessagesController;
use App\Http\Controllers\Others\ReviewController as OthersReviewController;

use App\Http\Controllers\StripePaymentController;
  
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

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
});

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

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
    Route::post('/life_remembered/update', [LifeRememberedController::class, 'update'])->name('life_remembered.update');

    // Customer Wishes
    Route::get('/wishes/view', [WishesController::class, 'view'])->name('wishes.view');
    Route::post('/wishes/update', [WishesController::class, 'update'])->name('wishes.update');

    // Customer Guidance
    Route::get('/guidance/view', [GuidanceController::class, 'view'])->name('guidance.view');
    Route::post('/guidance/update', [GuidanceController::class, 'update'])->name('guidance.update');

    // Custom Documents Type
    Route::post('/documents/save_custom_type', [DocumentsController::class, 'saveCustomType'])->name('documents.save_custom_type');
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

    // Organs Donation
    Route::get('/organs_donation/view', [OrgansDonationController::class, 'view'])->name('organs_donation.view');
    Route::post('/organs_donation/store', [OrgansDonationController::class, 'store'])->name('organs_donation.store');
    Route::post('/organs_donation/update/{id}', [OrgansDonationController::class, 'update'])->name('organs_donation.update');
    Route::delete('/organs_donation/destroy/{id}', [OrgansDonationController::class, 'destroy'])->name('organs_donation.destroy');

    // Voice Notes
    Route::get('/voice_notes/view', [VoiceNotesController::class, 'view'])->name('voice_notes.view');
    Route::post('/voice_notes/store', [VoiceNotesController::class, 'store'])->name('voice_notes.store');
    Route::delete('/voice_notes/destroy/{id}', [VoiceNotesController::class, 'destroy'])->name('voice_notes.destroy');

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
});


// Executors  Routes
Route::middleware(['auth', 'role:executor'])->prefix('executor')->name('executor.')->group(function () {

    
    // Reviews
    Route::post('reviews', [ExecutorReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [ExecutorReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [ExecutorReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/dashboard', [ExecutorDashboardController::class, 'index'])->name('dashboard');
    // Executors View Routes
    Route::get('/life_remembered/view', [ExecutorLifeRememberedController::class, 'view'])->name('life_remembered.view');
    Route::get('/wishes/view', [ExecutorWishesController::class, 'view'])->name('wishes.view');
    Route::get('/guidance/view', [ExecutorGuidanceController::class, 'view'])->name('guidance.view');
    Route::get('/documents/view', [ExecutorDocumentsController::class, 'view'])->name('documents.view');
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
    Route::get('/organs_donation/view', [ExecutorOrgansDonationController::class, 'view'])->name('organs_donation.view');
    Route::get('/voice_notes/view', [ExecutorVoiceNotesController::class, 'view'])->name('voice_notes.view');
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

    Route::middleware("permission:view wishes")->group(function () {
        Route::get('/wishes', [OthersWishesController::class, 'view'])->name('wishes.view');
    });

    Route::middleware("permission:view guidance")->group(function () {
        Route::get('/guidance', [OthersGuidanceController::class, 'view'])->name('guidance.view');
    });

    Route::middleware("permission:view life remembered")->group(function () {
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

    // Reviews
    Route::post('reviews', [OthersReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{id}', [ExecutorReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [OthersReviewController::class, 'destroy'])->name('reviews.destroy');
});
