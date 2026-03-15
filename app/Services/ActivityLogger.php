<?php

namespace App\Services;

use App\Models\ActivityLog;
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
use App\Models\User;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * @return array<class-string<Model>, string>
     */
    public static function observedModules(): array
    {
        return [
            Document::class => 'Documents',
            BankAccount::class => 'Bank Accounts',
            InvestmentAccount::class => 'Investment Accounts',
            Property::class => 'Properties',
            PersonalChattel::class => 'Personal Chattels',
            BusinessInterest::class => 'Business Interests',
            InsurancePolicy::class => 'Insurance Policies',
            DebtAndLiability::class => 'Debt & Liabilities',
            IntellectualProperty::class => 'Intellectual Properties',
            DigitalAsset::class => 'Digital Assets',
            ForeignAssets::class => 'Foreign Assets',
            OtherAsset::class => 'Other Assets',
            OtherTypeOfAsset::class => 'Other Type Of Assets',
            Wish::class => 'Wishes',
            MemorandumWish::class => 'Memorandum Wishes',
            Guidance::class => 'Guidance',
            LifeRemembered::class => 'Life Remembered',
            LifeRememberedVideo::class => 'Life Remembered Videos',
            Picture::class => 'Pictures',
            Video::class => 'Videos',
            PicturesAndVideos::class => 'Pictures & Videos',
            VoiceNotes::class => 'Voice Notes',
            FuneralPlan::class => 'Funeral Plans',
            FuneralWake::class => 'Funeral Wake',
            Task::class => 'Tasks',
            OrgansDonation::class => 'Organ Donations',
            Pension::class => 'Pensions',
            WillVideos::class => 'Wills',
            LPAVideos::class => 'LPA',
            WillUserInfo::class => 'Will Generator',
            WillUserPet::class => 'Will Generator',
            WillUserChildren::class => 'Will Generator',
            WillUserAccountsProperty::class => 'Will Generator',
            WillUserEstates::class => 'Will Generator',
            WillUserEstateInheritedIndividual::class => 'Will Generator',
            WillUserEstateInheritedAgency::class => 'Will Generator',
            WillInheritedPeople::class => 'Will Generator',
            WillUserExecutor::class => 'Will Generator',
            WillUserFuneral::class => 'Will Generator',
            WillUserInheritedGift::class => 'Will Generator',
        ];
    }

    /**
     * @return string[]
     */
    public static function allModuleLabels(): array
    {
        $labels = array_values(self::observedModules());
        $labels[] = 'Advisors';
        $labels[] = 'Executors';

        $labels = array_unique($labels);
        sort($labels);

        return $labels;
    }

    public function logModelActivity(Model $model, string $action): void
    {
        $module = self::observedModules()[$model::class] ?? null;

        if (!$module) {
            return;
        }

        $customerId = $this->resolveCustomerId($model);

        if (!$customerId) {
            return;
        }

        $this->writeLog([
            'customer_id' => $customerId,
            'module' => $module,
            'action' => $action,
            'subject_type' => class_basename($model),
            'subject_id' => $model->getKey(),
            'description' => $this->buildDescription($module, $action, $model),
            'meta' => [
                'attributes' => $this->extractInterestingAttributes($model),
            ],
        ]);
    }

    public function logManualActivity(
        int $customerId,
        string $module,
        string $action,
        string $subjectType,
        ?int $subjectId = null,
        ?string $description = null,
        array $meta = []
    ): void {
        $this->writeLog([
            'customer_id' => $customerId,
            'module' => $module,
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'description' => $description,
            'meta' => $meta,
        ]);
    }

    private function writeLog(array $payload): void
    {
        $user = Auth::user();

        ActivityLog::create([
            'customer_id' => $payload['customer_id'],
            'actor_user_id' => $user?->id,
            'actor_role' => $user?->getRoleNames()->first(),
            'module' => $payload['module'],
            'action' => $payload['action'],
            'subject_type' => $payload['subject_type'],
            'subject_id' => $payload['subject_id'],
            'description' => $payload['description'],
            'meta' => $payload['meta'] ?: null,
        ]);
    }

    private function resolveCustomerId(Model $model): ?int
    {
        if ($model->getAttribute('created_by')) {
            return (int) $model->getAttribute('created_by');
        }

        if ($model->getAttribute('customer_id')) {
            return (int) $model->getAttribute('customer_id');
        }

        if ($model->getAttribute('will_user_id')) {
            return WillUserInfo::query()
                ->whereKey($model->getAttribute('will_user_id'))
                ->value('created_by');
        }

        if ($model->getAttribute('will_user_info_id')) {
            return WillUserInfo::query()
                ->whereKey($model->getAttribute('will_user_info_id'))
                ->value('created_by');
        }

        if ($model instanceof User && $model->getAttribute('created_by')) {
            return (int) $model->getAttribute('created_by');
        }

        return null;
    }

    private function buildDescription(string $module, string $action, Model $model): string
    {
        $subjectLabel = $this->resolveSubjectLabel($model);

        return trim(sprintf('%s %s %s', $module, $action, $subjectLabel ? '(' . $subjectLabel . ')' : ''));
    }

    private function resolveSubjectLabel(Model $model): ?string
    {
        foreach (['name', 'title', 'document_type', 'bank_name', 'account_name', 'description'] as $attribute) {
            $value = $model->getAttribute($attribute);

            if (is_string($value) && $value !== '') {
                return mb_strimwidth($value, 0, 80, '...');
            }
        }

        return null;
    }

    private function extractInterestingAttributes(Model $model): array
    {
        $attributes = [];

        foreach (['name', 'title', 'document_type', 'created_by', 'customer_id'] as $key) {
            $value = $model->getAttribute($key);

            if ($value !== null && $value !== '') {
                $attributes[$key] = $value;
            }
        }

        return $attributes;
    }
}
