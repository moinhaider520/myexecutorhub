<?php

namespace App\Support;

use App\Models\OnboardingProgress;
use App\Models\User;

class PartnerActivationJourney
{
    public const STEP_WHAT_EXECUTOR_HUB_IS = 1;
    public const STEP_WHY_CLIENTS_BUY_IT = 2;
    public const STEP_HOW_YOU_EARN = 3;
    public const STEP_HOW_TO_INTRODUCE_IT = 4;
    public const STEP_FIRST_SALE_BLUEPRINT = 5;

    public static function progressFor(User $user): OnboardingProgress
    {
        return OnboardingProgress::firstOrCreate(['user_id' => $user->id]);
    }

    public static function currentStep(User $user): int
    {
        return (int) (self::progressFor($user)->partner_activation_step ?? 0);
    }

    public static function canAccess(User $user, int $step): bool
    {
        return self::currentStep($user) + 1 >= $step;
    }

    public static function markVisited(User $user, int $step): OnboardingProgress
    {
        $progress = self::progressFor($user);

        if ($progress->partner_activation_step < $step) {
            $progress->partner_activation_step = $step;
            $progress->save();
        }

        return $progress;
    }

    public static function complete(User $user): OnboardingProgress
    {
        $progress = self::progressFor($user);

        if (!$progress->partner_activation_completed_at) {
            $progress->partner_activation_step = max((int) $progress->partner_activation_step, self::STEP_FIRST_SALE_BLUEPRINT);
            $progress->partner_activation_completed_at = now();
            $progress->save();
        }

        return $progress;
    }

    public static function nextRouteName(User $user): string
    {
        return match (self::currentStep($user)) {
            0 => 'partner.knowledgebase.index',
            1 => 'partner.knowledgebase.why_clients_buy_it',
            2 => 'partner.commission_calculator.index',
            3 => 'partner.knowledgebase.best_practices',
            4 => 'partner.knowledgebase.first_sale_blueprint',
            default => 'partner.knowledgebase.quick_start_guide',
        };
    }
}
