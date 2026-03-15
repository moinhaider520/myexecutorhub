<?php

namespace App\Providers;

use App\Models\BankAccount;
use App\Models\BusinessInterest;
use App\Models\DebtAndLiability;
use App\Models\DigitalAsset;
use App\Models\Document;
use App\Models\ForeignAssets;
use App\Models\FuneralPlan;
use App\Models\FuneralWake;
use App\Models\Guidance;
use App\Models\InsurancePolicy;
use App\Models\IntellectualProperty;
use App\Models\InvestmentAccount;
use App\Models\LifeRemembered;
use App\Models\LifeRememberedVideo;
use App\Models\LPAVideos;
use App\Models\MemorandumWish;
use App\Models\OrgansDonation;
use App\Models\OtherAsset;
use App\Models\OtherTypeOfAsset;
use App\Models\Pension;
use App\Models\PersonalChattel;
use App\Models\Picture;
use App\Models\PicturesAndVideos;
use App\Models\Property;
use App\Models\Task;
use App\Models\Video;
use App\Models\VoiceNotes;
use App\Models\WillInheritedPeople;
use App\Models\WillUserAccountsProperty;
use App\Models\WillUserChildren;
use App\Models\WillUserEstateInheritedAgency;
use App\Models\WillUserEstateInheritedIndividual;
use App\Models\WillUserEstates;
use App\Models\WillUserExecutor;
use App\Models\WillUserFuneral;
use App\Models\WillUserInfo;
use App\Models\WillUserInheritedGift;
use App\Models\WillUserPet;
use App\Models\WillVideos;
use App\Models\Wish;
use App\Observers\ModelActivityObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([
            Document::class,
            BankAccount::class,
            InvestmentAccount::class,
            Property::class,
            PersonalChattel::class,
            BusinessInterest::class,
            InsurancePolicy::class,
            DebtAndLiability::class,
            IntellectualProperty::class,
            DigitalAsset::class,
            ForeignAssets::class,
            OtherAsset::class,
            OtherTypeOfAsset::class,
            Wish::class,
            MemorandumWish::class,
            Guidance::class,
            LifeRemembered::class,
            LifeRememberedVideo::class,
            Picture::class,
            Video::class,
            PicturesAndVideos::class,
            VoiceNotes::class,
            FuneralPlan::class,
            FuneralWake::class,
            Task::class,
            OrgansDonation::class,
            Pension::class,
            WillVideos::class,
            LPAVideos::class,
            WillUserInfo::class,
            WillUserPet::class,
            WillUserChildren::class,
            WillUserAccountsProperty::class,
            WillUserEstates::class,
            WillUserEstateInheritedIndividual::class,
            WillUserEstateInheritedAgency::class,
            WillInheritedPeople::class,
            WillUserExecutor::class,
            WillUserFuneral::class,
            WillUserInheritedGift::class,
        ] as $model) {
            $model::observe(ModelActivityObserver::class);
        }
    }
}
