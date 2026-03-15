<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $password = str()->random(10);
            $isExistingExecutor = (bool) $executor;

            if ($executor) {
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

                $executor->update([
                    'password' => Hash::make($password),
                ]);
            } else {
                $executor = User::create([
                    'title' => $request->title,
                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'how_acting' => $request->how_acting,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'relationship' => $request->relationship,
                    'status' => $request->status,
                    'password' => Hash::make($password),
                ]);

                $executor->assignRole('executor');
            }

            Auth::user()->executors()->syncWithoutDetaching([$executor->id]);

            $this->sendExecutorAccessEmail($executor, $password, $isExistingExecutor);

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
                'status' => $request->status,
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

    private function sendExecutorAccessEmail(User $executor, string $password, bool $isExistingExecutor): void
    {
        $authname = Auth::user()->name;
        $intro = $isExistingExecutor
            ? "{$authname} has linked you as an executor on <strong>Executor Hub</strong>."
            : "You’ve been invited to use <strong>Executor Hub</strong> as an Executor by {$authname}.";
        $message = "
            <h2>Hello {$executor->name},</h2>
            <p>{$intro}</p>
            <p>Please use the following credentials to log in to the portal.</p>
            <p>Email: {$executor->email}</p>
            <p>Password: {$password}</p>
            <p><a href='https://executorhub.co.uk/'>Click here to log in</a></p>
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
}
