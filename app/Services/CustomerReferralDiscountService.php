<?php

namespace App\Services;

use App\Models\CustomerReferralInvite;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerReferralDiscountService
{
    public function resolveDiscount(Request $request, ?string $email = null): ?array
    {
        $invite = $this->resolveInviteFromSession($request, $email);
        if ($invite) {
            $existingUser = $email ? User::where('email', $email)->first() : $invite->invitedUser;

            if ($existingUser && $this->hasPurchaseHistory($existingUser)) {
                return null;
            }

            if ($existingUser && $existingUser->id === $invite->referrer_user_id) {
                return null;
            }

            if ($email && strcasecmp($invite->referrer->email ?? '', $email) === 0) {
                return null;
            }

            return [
                'type' => 'invite',
                'discount_percent' => (int) ($invite->discount_percent ?? 10),
                'invite' => $invite,
                'referrer' => $invite->referrer,
                'expires_at' => $invite->expires_at,
                'description' => sprintf(
                    '%d%% referral discount valid until %s.',
                    (int) ($invite->discount_percent ?? 10),
                    optional($invite->expires_at)?->format('d M Y, H:i')
                ),
            ];
        }

        return $this->resolveShareDiscount($request, $email);
    }

    public function previewDiscount(Request $request): ?array
    {
        return $this->resolveDiscount($request);
    }

    protected function resolveInviteFromSession(Request $request, ?string $email = null): ?CustomerReferralInvite
    {
        $token = $request->session()->get('customer_referral_invite_token');
        if (!$token) {
            return null;
        }

        $invite = CustomerReferralInvite::with(['referrer', 'invitedUser'])
            ->where('token', $token)
            ->first();

        if (!$invite || ($invite->expires_at && $invite->expires_at->isPast())) {
            return null;
        }

        if ($email) {
            $matchesInviteEmail = strcasecmp($invite->email, $email) === 0;
            $matchesInvitedUser = $invite->invitedUser && strcasecmp($invite->invitedUser->email, $email) === 0;

            if (!$matchesInviteEmail && !$matchesInvitedUser) {
                return null;
            }
        }

        return $invite;
    }

    protected function resolveShareDiscount(Request $request, ?string $email = null): ?array
    {
        if (!$email) {
            return null;
        }

        $referrerId = $request->session()->get('customer_referrer_user_id');
        $referralCode = $request->session()->get('customer_referral_code');

        if (!$referrerId || !$referralCode) {
            return null;
        }

        $referrer = User::find($referrerId);
        if (!$referrer) {
            return null;
        }

        if (strcasecmp($referrer->email, $email) === 0) {
            return null;
        }

        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            if ($existingUser->id === $referrer->id || $this->hasPurchaseHistory($existingUser)) {
                return null;
            }
        }

        return [
            'type' => 'share',
            'discount_percent' => 10,
            'invite' => null,
            'referrer' => $referrer,
            'expires_at' => null,
            'description' => '10% referral discount will be applied to your first eligible purchase.',
        ];
    }

    protected function hasPurchaseHistory(User $user): bool
    {
        if (!empty($user->stripe_subscription_id) || !empty($user->paypal_subscription_id)) {
            return true;
        }

        if (!empty($user->subscribed_package) && $user->subscribed_package !== 'free_trial') {
            return true;
        }

        return false;
    }
}
