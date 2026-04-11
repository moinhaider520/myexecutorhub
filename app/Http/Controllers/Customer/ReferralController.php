<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\CustomerReferral;
use App\Models\CustomerReferralInvite;
use App\Models\CustomerWallet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReferralController extends Controller
{
    public function index(): View
    {
        $customer = Auth::user();
        $wallet = $this->getOrCreateWallet($customer);
        $referralCode = $this->ensureReferralCode($customer);

        $invites = CustomerReferralInvite::with('invitedUser')
            ->where('referrer_user_id', $customer->id)
            ->latest()
            ->get();

        $referralsUsed = CustomerReferral::where('referrer_user_id', $customer->id)
            ->where('status', 'confirmed')
            ->count();

        $pendingRewards = CustomerReferral::where('referrer_user_id', $customer->id)
            ->where('status', 'pending')
            ->count();

        $progressPercent = (int) min(100, round(($referralsUsed / 10) * 100));
        $personalReferralLink = route('referrals.share', ['code' => $referralCode]);

        return view('customer.referrals.index', compact(
            'customer',
            'wallet',
            'invites',
            'referralsUsed',
            'pendingRewards',
            'progressPercent',
            'personalReferralLink',
            'referralCode'
        ));
    }

    public function share(string $code): View
    {
        $referrer = User::where('coupon_code', $code)->firstOrFail();

        session([
            'customer_referral_code' => $code,
            'customer_referrer_user_id' => $referrer->id,
        ]);

        return view('customer.referrals.landing', [
            'mode' => 'share',
            'referrer' => $referrer,
            'invite' => null,
            'callToActionUrl' => route('home'),
            'callToActionLabel' => 'Explore Executor Hub',
        ]);
    }

    public function accept(string $token): View
    {
        $invite = CustomerReferralInvite::with(['referrer', 'invitedUser'])->where('token', $token)->firstOrFail();

        if ($invite->opened_at === null) {
            $invite->forceFill([
                'opened_at' => now(),
                'status' => 'opened',
            ])->save();
        }

        $callToActionUrl = route('home');
        $callToActionLabel = 'Learn More';

        if ($invite->invitedUser) {
            if ($invite->invitedUser->needsInviteActivation()) {
                $callToActionUrl = route('executor.activate.show', $invite->invitedUser->executor_invite_token);
                $callToActionLabel = 'Activate Account';
            } else {
                $callToActionUrl = route('login');
                $callToActionLabel = 'Log In';
            }
        }

        session([
            'customer_referral_invite_token' => $invite->token,
            'customer_referral_code' => $invite->referral_code,
            'customer_referrer_user_id' => $invite->referrer_user_id,
        ]);

        return view('customer.referrals.landing', [
            'mode' => 'invite',
            'referrer' => $invite->referrer,
            'invite' => $invite,
            'callToActionUrl' => $callToActionUrl,
            'callToActionLabel' => $callToActionLabel,
        ]);
    }

    public function sendExecutorInvite(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'relationship' => 'required|string|max:255',
            'how_acting' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
        ]);

        $customer = Auth::user();
        $referralCode = $this->ensureReferralCode($customer);

        DB::transaction(function () use ($request, $customer, $referralCode) {
            $executor = User::where('email', $request->email)->first();

            if ($executor && $executor->hasAnyRole(['admin', 'partner'])) {
                throw ValidationException::withMessages([
                    'email' => 'This email already belongs to an account that cannot be linked as an executor.',
                ]);
            }

            if ($executor) {
                $alreadyLinked = $customer->executors()->where('users.id', $executor->id)->exists();
                if ($alreadyLinked) {
                    throw ValidationException::withMessages([
                        'email' => 'This executor is already linked to your account.',
                    ]);
                }

                if (!$request->boolean('confirm_existing_executor')) {
                    if ($request->expectsJson()) {
                        throw new HttpResponseException(response()->json([
                            'success' => false,
                            'requires_confirmation' => true,
                            'message' => 'An executor with this email already exists. Do you want to link the same executor to your account?',
                        ], 409));
                    }

                    throw ValidationException::withMessages([
                        'email' => 'An executor with this email already exists. Please confirm that you want to link the same executor to your account.',
                    ]);
                }

                if (!$executor->hasRole('executor')) {
                    $executor->assignRole('executor');
                }

                if ($executor->needsExecutorActivation() && !$executor->executor_invite_token) {
                    $executor->markExecutorInviteIssued();
                }
            } else {
                $executor = User::create([
                    'title' => $request->title,
                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'how_acting' => $request->how_acting,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'relationship' => $request->relationship,
                    'status' => 'A',
                    'access_type' => $request->status,
                    'password' => Hash::make(Str::random(24)),
                    'user_role' => 'executor',
                    'preferred_role' => 'executor',
                ]);

                $executor->assignRole('executor');
                $executor->markExecutorInviteIssued(Str::random(64));
            }

            $customer->executors()->syncWithoutDetaching([$executor->id]);

            $invite = CustomerReferralInvite::create([
                'referrer_user_id' => $customer->id,
                'invited_user_id' => $executor->id,
                'invite_type' => 'executor',
                'name' => trim($executor->name . ' ' . $executor->lastname),
                'email' => $executor->email,
                'token' => Str::random(64),
                'referral_code' => $referralCode,
                'discount_percent' => 10,
                'status' => 'sent',
                'expires_at' => now()->addDays(10),
                'last_sent_at' => now(),
                'meta' => [
                    'relationship' => $request->relationship,
                    'how_acting' => $request->how_acting,
                ],
            ]);

            $this->sendInviteEmail($invite, $executor, 'executor');
        });

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Executor invite sent successfully.',
            ]);
        }

        return redirect()->route('customer.referrals.index')->with('success', 'Executor invite sent successfully.');
    }

    public function sendAdvisorInvite(Request $request): RedirectResponse
    {
        $request->validate([
            'adviser_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'practice_name' => 'required|string|max:255',
            'practice_address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
        ]);

        $customer = Auth::user();
        $referralCode = $this->ensureReferralCode($customer);

        DB::transaction(function () use ($request, $customer, $referralCode) {
            $advisor = User::where('email', $request->email)->first();

            if ($advisor && $advisor->hasAnyRole(['admin', 'partner', 'customer'])) {
                throw ValidationException::withMessages([
                    'email' => 'This email already belongs to an account that cannot be linked as an adviser invite.',
                ]);
            }

            if (!$advisor) {
                $advisor = User::create([
                    'name' => $request->name,
                    'practice_name' => $request->practice_name,
                    'practice_address' => $request->practice_address,
                    'email' => $request->email,
                    'contact_number' => $request->phone_number,
                    'password' => Hash::make(Str::random(24)),
                    'created_by' => $customer->id,
                    'user_role' => $request->adviser_type,
                ]);
            }

            $advisor->syncRoles([$request->adviser_type]);

            if ($advisor->executor_activated_at === null && !$advisor->needsInviteActivation()) {
                $advisor->markExecutorInviteIssued(Str::random(64));
            }

            $invite = CustomerReferralInvite::create([
                'referrer_user_id' => $customer->id,
                'invited_user_id' => $advisor->id,
                'invite_type' => 'advisor',
                'name' => $advisor->name,
                'email' => $advisor->email,
                'token' => Str::random(64),
                'referral_code' => $referralCode,
                'discount_percent' => 10,
                'status' => 'sent',
                'expires_at' => now()->addDays(10),
                'last_sent_at' => now(),
                'meta' => [
                    'adviser_type' => $request->adviser_type,
                    'practice_name' => $request->practice_name,
                ],
            ]);

            $this->sendInviteEmail($invite, $advisor, 'advisor');
        });

        return redirect()->route('customer.referrals.index')->with('success', 'Advisor invite sent successfully.');
    }

    protected function sendInviteEmail(CustomerReferralInvite $invite, User $invitee, string $type): void
    {
        $customer = $invite->referrer;
        $acceptUrl = route('customer.referrals.accept', $invite->token);
        $expiryText = $invite->expires_at instanceof Carbon
            ? $invite->expires_at->format('j M Y, g:i A')
            : '';

        $roleLabel = $type === 'executor' ? 'Executor' : 'Adviser';
        $message = "
            <h2>Hello {$invitee->name},</h2>
            <p><strong>{$customer->name}</strong> has invited you to join Executor Hub as an {$roleLabel}.</p>
            <p>You have a referral invitation waiting for you with <strong>10% off</strong> that is valid until <strong>{$expiryText}</strong>.</p>
            <p><a href='{$acceptUrl}'>Open your invitation</a></p>
            <p>If you activate your account now, your referral will stay connected to your first eligible purchase.</p>
            <p>Regards,<br>Executor Hub Team</p>
        ";

        Mail::to($invite->email)->send(new CustomEmail(
            [
                'subject' => "You're Invited to Executor Hub",
                'message' => $message,
            ],
            "You're Invited to Executor Hub"
        ));
    }

    protected function ensureReferralCode(User $customer): string
    {
        if (!empty($customer->coupon_code)) {
            return $customer->coupon_code;
        }

        do {
            $code = 'CUST-' . strtoupper(Str::random(8));
        } while (User::where('coupon_code', $code)->exists());

        $customer->forceFill(['coupon_code' => $code])->save();

        return $code;
    }

    protected function getOrCreateWallet(User $customer): CustomerWallet
    {
        return CustomerWallet::firstOrCreate(
            ['user_id' => $customer->id],
            [
                'available_balance' => 0,
                'pending_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]
        );
    }
}
