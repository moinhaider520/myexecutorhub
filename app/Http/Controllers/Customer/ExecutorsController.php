<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\CustomerReferralInvite;
use App\Models\User;
use App\Services\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

class ExecutorsController extends Controller
{
    public function view()
    {
        $executors = Auth::user()->executors;

        return view('customer.executors.executors', compact('executors'));
    }

    public function store(Request $request, ActivityLogger $activityLogger)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'relationship' => 'required|string',
            'how_acting' => 'required|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $executor = User::where('email', $request->email)->first();
            $password = str()->random(24);
            $isExistingExecutor = (bool) $executor;

            if ($executor) {
                if ($executor->hasAnyRole(['admin', 'partner'])) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'This email already belongs to an account that cannot be linked as an executor.',
                    ], 422);
                }

                $alreadyLinked = Auth::user()->executors()->where('users.id', $executor->id)->exists();

                if ($alreadyLinked) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed.',
                        'errors' => [
                            'email' => ['This executor is already linked to your account.'],
                        ],
                    ], 422);
                }

                if (!$request->boolean('confirm_existing_executor')) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'requires_confirmation' => true,
                        'message' => 'An executor with this email already exists. Do you want to link the same executor to your account?',
                    ], 409);
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
                    'password' => Hash::make($password),
                    'user_role' => 'executor',
                    'preferred_role' => 'executor',
                ]);

                $executor->assignRole('executor');
                $executor->markExecutorInviteIssued(Str::random(64));
            }

            Auth::user()->executors()->syncWithoutDetaching([$executor->id]);

            $this->sendExecutorAccessEmail($executor, $isExistingExecutor);
            $referralInvite = $this->createOrRefreshExecutorReferralInvite(Auth::user(), $executor, $request);
            $this->sendReferralInviteEmail($referralInvite, $executor);

            $activityLogger->logManualActivity(
                customerId: Auth::id(),
                module: 'Executors',
                action: 'created',
                subjectType: 'Executor',
                subjectId: $executor->id,
                description: 'Executor linked (' . trim($executor->name . ' ' . $executor->lastname) . ')',
                meta: [
                    'email' => $executor->email,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $isExistingExecutor
                    ? 'Existing executor linked successfully.'
                    : 'Executor linked successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id, ActivityLogger $activityLogger)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'how_acting' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'relationship' => 'required|string',
            'status' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $executor = User::findOrFail($id);
            $executor->update([
                'title' => $request->title,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'how_acting' => $request->how_acting,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'relationship' => $request->relationship,
                'access_type' => $request->status,
                'password' => $request->filled('password') ? Hash::make($request->password) : $executor->password,
            ]);

            $activityLogger->logManualActivity(
                customerId: Auth::id(),
                module: 'Executors',
                action: 'updated',
                subjectType: 'Executor',
                subjectId: $executor->id,
                description: 'Executor updated (' . trim($executor->name . ' ' . $executor->lastname) . ')',
                meta: [
                    'email' => $executor->email,
                ]
            );

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Executor updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id, ActivityLogger $activityLogger)
    {
        try {
            DB::beginTransaction();

            $executor = User::findOrFail($id);
            Auth::user()->executors()->detach($id);
            $this->cancelOpenExecutorReferralInvites(Auth::user(), $executor);

            $activityLogger->logManualActivity(
                customerId: Auth::id(),
                module: 'Executors',
                action: 'deleted',
                subjectType: 'Executor',
                subjectId: $executor->id,
                description: 'Executor unlinked (' . trim($executor->name . ' ' . $executor->lastname) . ')',
                meta: [
                    'email' => $executor->email,
                ]
            );

            DB::commit();

            return redirect()->route('customer.executors.view')->with('success', 'Executor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function sendExecutorAccessEmail(User $executor, bool $isExistingExecutor): void
    {
        $authname = Auth::user()->name;
        $intro = $isExistingExecutor
            ? "{$authname} has linked you as an executor on <strong>Executor Hub</strong>."
            : "You've been invited to use <strong>Executor Hub</strong> as an Executor by {$authname}.";

        $message = "
            <h2>Hello {$executor->name},</h2>
            <p>{$intro}</p>
        ";

        if ($executor->needsExecutorActivation() && $executor->executor_invite_token) {
            $activationLink = route('executor.activate.show', $executor->executor_invite_token);
            $message .= "
                <p>Click below to activate your executor account and choose your own password.</p>
                <p><a href='{$activationLink}'>Activate Account</a></p>
            ";
        } else {
            $message .= "
                <p>You can sign in using your existing Executor Hub account.</p>
                <p><a href='" . route('login') . "'>Click here to log in</a></p>
            ";
        }

        $message .= "
            <p>Regards,<br>Executor Hub Team</p>
        ";

        Mail::to($executor->email)->send(new CustomEmail(
            [
                'subject' => 'You Have Been Invited to Executor Hub.',
                'message' => $message,
            ],
            'You Have Been Invited to Executor Hub.'
        ));
    }

    private function createOrRefreshExecutorReferralInvite(User $customer, User $executor, Request $request): CustomerReferralInvite
    {
        $referralCode = $this->ensureReferralCode($customer);

        $invite = CustomerReferralInvite::query()
            ->where('referrer_user_id', $customer->id)
            ->where('invite_type', 'executor')
            ->where(function ($query) use ($executor) {
                $query->where('invited_user_id', $executor->id)
                    ->orWhere('email', $executor->email);
            })
            ->whereIn('status', ['sent', 'opened', 'activated'])
            ->latest('id')
            ->first();

        $payload = [
            'invited_user_id' => $executor->id,
            'name' => trim($executor->name . ' ' . $executor->lastname),
            'email' => $executor->email,
            'referral_code' => $referralCode,
            'discount_percent' => 10,
            'status' => 'sent',
            'expires_at' => now()->addDays(10),
            'last_sent_at' => now(),
            'meta' => [
                'relationship' => $request->relationship,
                'how_acting' => $request->how_acting,
                'source' => 'customer_executors_manager',
            ],
        ];

        if ($invite) {
            $invite->update($payload);

            return $invite->fresh();
        }

        return CustomerReferralInvite::create(array_merge($payload, [
            'referrer_user_id' => $customer->id,
            'token' => Str::random(64),
            'invite_type' => 'executor',
        ]));
    }

    private function cancelOpenExecutorReferralInvites(User $customer, User $executor): void
    {
        CustomerReferralInvite::query()
            ->where('referrer_user_id', $customer->id)
            ->where('invite_type', 'executor')
            ->where(function ($query) use ($executor) {
                $query->where('invited_user_id', $executor->id)
                    ->orWhere('email', $executor->email);
            })
            ->whereIn('status', ['sent', 'opened', 'activated'])
            ->update([
                'status' => 'cancelled',
            ]);
    }

    private function sendReferralInviteEmail(CustomerReferralInvite $invite, User $executor): void
    {
        $customer = Auth::user();
        $acceptUrl = route('customer.referrals.accept', $invite->token);
        $expiryText = $invite->expires_at instanceof Carbon
            ? $invite->expires_at->format('j M Y, g:i A')
            : '';

        $message = "
            <h2>Hello {$executor->name},</h2>
            <p><strong>{$customer->name}</strong> has invited you to join Executor Hub as an Executor.</p>
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

    private function ensureReferralCode(User $customer): string
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
}
