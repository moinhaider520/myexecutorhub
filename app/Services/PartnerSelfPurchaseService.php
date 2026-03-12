<?php

namespace App\Services;

use App\Jobs\ProvisionLinkedCustomerMailbox;
use App\Models\CouponUsage;
use App\Models\PartnerCustomerAccount;
use App\Models\PartnerSelfPurchaseCampaign;
use App\Models\PartnerSelfPurchaseQualifyingReferral;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerSelfPurchaseService
{
    public function createLinkedCustomerAccountForPartner(
        User $partner,
        string $planLabel = 'Partner Linked Customer Access'
    ): array
    {
        $created = DB::transaction(function () use ($partner, $planLabel) {
            $mailboxEmail = $this->generateUniqueCustomerMailboxEmail($partner->email);
            $temporaryPassword = Str::random(20);
            $couponCode = 'CUST-' . strtoupper(Str::random(10));

            $customerUser = User::create([
                'name' => $partner->name,
                'email' => $mailboxEmail,
                'password' => Hash::make($temporaryPassword),
                'trial_ends_at' => now()->addYears(10),
                'subscribed_package' => $planLabel,
                'user_role' => 'customer',
                'status' => 'N',
                'coupon_code' => $couponCode,
                'hear_about_us' => $partner->hear_about_us,
                'other_hear_about_us' => $partner->other_hear_about_us,
                'email_notifications' => $partner->email_notifications,
                'created_by' => $partner->id,
            ]);

            $customerUser->assignRole('customer');

            $link = PartnerCustomerAccount::create([
                'partner_user_id' => $partner->id,
                'customer_user_id' => $customerUser->id,
                'mailbox_email' => $mailboxEmail,
                'requested_local_part' => Str::before($mailboxEmail, '@'),
                'provision_status' => 'pending',
                'provider' => 'cpanel',
            ]);

            return [
                'customer_user' => $customerUser,
                'link' => $link,
                'temporary_password' => $temporaryPassword,
            ];
        });

        ProvisionLinkedCustomerMailbox::dispatch(
            $created['link']->id,
            Crypt::encryptString($created['temporary_password'])
        );

        return $created;
    }

    public function startCampaign(
        User $partner,
        User $customer,
        float $purchaseAmount,
        float $vatAmount = 0.0,
        float $rewardAmount = 99.0
    ): PartnerSelfPurchaseCampaign {
        return PartnerSelfPurchaseCampaign::create([
            'partner_user_id' => $partner->id,
            'customer_user_id' => $customer->id,
            'plan_tier' => 'standard',
            'purchase_amount' => $purchaseAmount,
            'vat_amount' => $vatAmount,
            'reward_amount' => $rewardAmount,
            'purchased_at' => now(),
            'qualification_deadline' => now()->addMonths(6),
            'status' => 'active',
        ]);
    }

    public function recordQualifyingLifetimeReferral(User $customer, string $planTier): void
    {
        if (!in_array($planTier, ['standard', 'premium'], true)) {
            return;
        }

        $couponUsage = CouponUsage::where('user_id', $customer->id)->first();

        if (!$couponUsage) {
            return;
        }

        $campaign = PartnerSelfPurchaseCampaign::where('partner_user_id', $couponUsage->partner_id)
            ->where('status', 'active')
            ->where('qualification_deadline', '>=', now())
            ->orderByDesc('purchased_at')
            ->first();

        if (!$campaign) {
            PartnerSelfPurchaseCampaign::where('partner_user_id', $couponUsage->partner_id)
                ->where('status', 'active')
                ->where('qualification_deadline', '<', now())
                ->update(['status' => 'expired']);

            return;
        }

        if ($customer->created_at && $customer->created_at->lt($campaign->purchased_at)) {
            return;
        }

        if (PartnerSelfPurchaseQualifyingReferral::where('campaign_id', $campaign->id)
            ->where('referred_customer_user_id', $customer->id)
            ->exists()) {
            return;
        }

        DB::transaction(function () use ($campaign, $couponUsage, $customer, $planTier) {
            PartnerSelfPurchaseQualifyingReferral::create([
                'campaign_id' => $campaign->id,
                'partner_user_id' => $couponUsage->partner_id,
                'referred_customer_user_id' => $customer->id,
                'qualifying_plan_tier' => $planTier,
                'qualified_at' => now(),
            ]);

            $campaign->increment('qualifying_referrals_count');
            $campaign->refresh();

            if (
                $campaign->reward_granted_at === null &&
                $campaign->qualifying_referrals_count >= $campaign->qualifying_referrals_required
            ) {
                User::whereKey($campaign->partner_user_id)
                    ->increment('commission_amount', $campaign->reward_amount);

                $campaign->update([
                    'reward_granted_at' => now(),
                    'status' => 'rewarded',
                ]);
            }
        });
    }

    public function generateUniqueCustomerMailboxEmail(string $sourceEmail): string
    {
        $domain = (string) config('services.cpanel.domain', 'executorhub.co.uk');
        $base = Str::of(Str::before($sourceEmail, '@'))
            ->lower()
            ->replaceMatches('/[^a-z0-9._-]/', '')
            ->trim('.-_')
            ->value();

        $base = $base !== '' ? $base : 'customer';
        $candidate = "{$base}@{$domain}";
        $counter = 1;

        while (User::where('email', $candidate)->exists()) {
            $candidate = "{$base}.{$counter}@{$domain}";
            $counter++;
        }

        return $candidate;
    }
}
