<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, HasRoles;

    public const DASHBOARD_ROLE_PRIORITY = [
        'admin',
        'partner',
        'customer',
        'executor',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'executor_invited_at' => 'datetime',
            'executor_activated_at' => 'datetime',
            'date_of_birth' => 'date',
            'date_of_death' => 'date',
            'deceased_verified_at' => 'datetime',
        ];
    }

    public function availableDashboardRoles(): array
    {
        $roleNames = $this->getRoleNames()->all();

        return array_values(array_filter(
            self::DASHBOARD_ROLE_PRIORITY,
            fn (string $role): bool => in_array($role, $roleNames, true)
        ));
    }

    public function canSwitchDashboardRoles(): bool
    {
        return count($this->availableDashboardRoles()) > 1;
    }

    public function activeDashboardRole(): ?string
    {
        $availableRoles = $this->availableDashboardRoles();

        if ($availableRoles === []) {
            return null;
        }

        $sessionRole = session('active_role');
        if (is_string($sessionRole) && in_array($sessionRole, $availableRoles, true)) {
            return $sessionRole;
        }

        if (
            is_string($this->preferred_role) &&
            in_array($this->preferred_role, $availableRoles, true)
        ) {
            return $this->preferred_role;
        }

        return $availableRoles[0];
    }

    public function dashboardRouteName(?string $role = null): string
    {
        return match ($role ?? $this->activeDashboardRole()) {
            'admin' => 'admin.dashboard',
            'partner' => 'partner.dashboard',
            'customer' => 'customer.dashboard',
            'executor' => 'executor.dashboard',
            default => 'dashboard',
        };
    }

    public function settingsRouteName(?string $role = null): ?string
    {
        return match ($role ?? $this->activeDashboardRole()) {
            'admin' => 'admin.edit_profile',
            'partner' => 'partner.edit_profile',
            'customer' => 'customer.edit_profile',
            'executor' => $this->hasRole('customer') ? 'customer.edit_profile' : null,
            default => null,
        };
    }

    public function roleDisplayName(?string $role = null): string
    {
        return ucwords(str_replace('_', ' ', $role ?? $this->activeDashboardRole() ?? 'user'));
    }

    public function isExecutorOnlyAccount(): bool
    {
        return $this->hasRole('executor')
            && !$this->hasRole('customer')
            && !$this->hasRole('partner')
            && !$this->hasRole('admin');
    }

    public function canUpgradeToCustomer(): bool
    {
        return $this->isExecutorOnlyAccount();
    }

    public function needsExecutorActivation(): bool
    {
        return $this->isExecutorOnlyAccount() && $this->executor_activated_at === null;
    }

    public function needsInviteActivation(): bool
    {
        return $this->executor_invite_token !== null && $this->executor_activated_at === null;
    }

    public function markExecutorInviteIssued(?string $token = null): string
    {
        $token ??= (string) str()->random(64);

        $this->forceFill([
            'executor_invite_token' => $token,
            'executor_invited_at' => now(),
        ])->save();

        return $token;
    }

    public function markExecutorActivated(): void
    {
        $this->forceFill([
            'executor_activated_at' => now(),
            'executor_invite_token' => null,
        ])->save();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function onboardingProgress()
    {
        return $this->hasOne(OnboardingProgress::class, 'user_id');
    }

    public function referredUsers()
    {
        return $this->hasMany(CouponUsage::class, 'partner_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'reffered_by');
    }

    public function usedCouponFrom()
    {
        return $this->hasOne(CouponUsage::class, 'user_id');
    }

    public function parentPartnerRelation()
    {
        return $this->hasOne(PartnerRelationship::class, 'sub_partner_id');
    }

    // Relationship to get the actual parent partner user
    public function parentPartner()
    {
        return $this->hasOneThrough(
            User::class,
            PartnerRelationship::class,
            'sub_partner_id', // Foreign key on PartnerRelationship
            'id', // Foreign key on User
            'id', // Local key on current User
            'parent_partner_id' // Local key on PartnerRelationship
        );
    }

    // Relationship to get all sub-partners under this partner
    public function subPartners()
    {
        return $this->hasManyThrough(
            User::class,
            PartnerRelationship::class,
            'parent_partner_id', // Foreign key on PartnerRelationship
            'id', // Foreign key on User
            'id', // Local key on current User
            'sub_partner_id' // Local key on PartnerRelationship
        );
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'user_id');
    }

    public function customerPartnerAccount()
    {
        return $this->hasOne(CustomerPartnerAccount::class, 'customer_user_id');
    }

    public function customerWallet()
    {
        return $this->hasOne(CustomerWallet::class, 'user_id');
    }

    public function sentReferralInvites()
    {
        return $this->hasMany(CustomerReferralInvite::class, 'referrer_user_id');
    }

    public function receivedReferralInvites()
    {
        return $this->hasMany(CustomerReferralInvite::class, 'invited_user_id');
    }

    public function customerReferrals()
    {
        return $this->hasMany(CustomerReferral::class, 'referrer_user_id');
    }

    public function earnedReferralRewards()
    {
        return $this->hasMany(CustomerReferral::class, 'referred_user_id');
    }

    public function linkedCustomerAccount()
    {
        return $this->hasOne(CustomerPartnerAccount::class, 'partner_user_id');
    }

    public function linkedPartnerCustomerAccount()
    {
        return $this->hasOne(PartnerCustomerAccount::class, 'partner_user_id');
    }

    public function partnerOwnedCustomerAccount()
    {
        return $this->hasOne(PartnerCustomerAccount::class, 'customer_user_id');
    }

    public function partnerSelfPurchaseCampaigns()
    {
        return $this->hasMany(PartnerSelfPurchaseCampaign::class, 'partner_user_id');
    }


    public function weeklySummaries()
    {
        return $this->hasMany(PartnerWeeklySummary::class, 'created_by');
    }

    public function executors()
    {
        return $this->belongsToMany(
            User::class,
            'customer_executor',
            'customer_id',
            'executor_id'
        );
    }

    // Executor → Customers
    public function customers()
    {
        return $this->belongsToMany(
            User::class,
            'customer_executor',
            'executor_id',
            'customer_id'
        );
    }

    public function deathCertificateVerifications()
    {
        return $this->hasMany(DeathCertificateVerification::class, 'customer_id');
    }

    public function deceasedCase()
    {
        return $this->hasOne(DeceasedCase::class, 'customer_id');
    }

    public function isDeceasedCustomer(): bool
    {
        return $this->hasRole('customer') && $this->death_verification_status === 'verified';
    }

    public function getProfileImageUrlAttribute()
    {
        if (!$this->profile_image) {
            return asset('assets/images/dashboard/profile.png');
        }

        if (str_starts_with($this->profile_image, 'http')) {
            return $this->profile_image;
        }

        return asset('assets/upload/' . $this->profile_image);
    }
}
