<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\DeceasedCase;
use App\Models\DeceasedCaseNotification;
use App\Models\DeceasedCaseOrganization;
use App\Services\DeceasedCaseService;
use App\Services\DeceasedCaseEstateMappingService;
use App\Services\DeceasedCaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeceasedCaseController extends Controller
{
    public function show(DeceasedCaseService $deceasedCaseService)
    {
        $contextUser = ContextHelper::user();

        $deceasedCase = DeceasedCase::with(['customer', 'organizations.notifications', 'organizations.replies'])
            ->where('customer_id', $contextUser->id)
            ->first();

        if (!$deceasedCase && $contextUser->death_verification_status === 'verified') {
            $deceasedCase = $deceasedCaseService->createOrRefreshForCustomer($contextUser, openedBy: Auth::id())
                ->load(['customer', 'organizations.notifications', 'organizations.replies']);
        }

        if (!$deceasedCase) {
            return view('executor.deceased_cases.not_ready', [
                'contextUser' => $contextUser,
            ]);
        }

        $statusCounts = $deceasedCase->organizations
            ->groupBy('status')
            ->map->count()
            ->sortKeys();

        $organisationTypes = DeceasedCaseNotificationService::ORGANISATION_TYPES;
        $organisationStatuses = DeceasedCaseNotificationService::ORGANISATION_STATUSES;
        $linkedCustomers = Auth::user()->customers()
            ->with('deceasedCase')
            ->orderBy('name')
            ->get();

        return view('executor.deceased_cases.show', compact('deceasedCase', 'contextUser', 'statusCounts', 'organisationTypes', 'organisationStatuses', 'linkedCustomers'));
    }

    public function switchCustomer(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
        ]);

        abort_unless(
            Auth::user()->customers()->where('users.id', $validated['customer_id'])->exists(),
            403
        );

        session(['acting_customer_id' => $validated['customer_id']]);

        return redirect()->route('executor.deceased_cases.show');
    }

    public function storeOrganization(Request $request)
    {
        $deceasedCase = $this->currentCase();

        $validated = $request->validate([
            'organisation_name' => 'required|string|max:255',
            'organisation_type' => 'required|string|max:255',
            'organisation_contact_name' => 'nullable|string|max:255',
            'organisation_email' => 'nullable|email|max:255',
            'organisation_address' => 'nullable|string|max:1000',
            'organisation_reference' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'policy_number' => 'nullable|string|max:255',
            'customer_number' => 'nullable|string|max:255',
            'service_address' => 'nullable|string|max:255',
        ]);

        $deceasedCase->organizations()->create(array_merge($validated, [
            'status' => 'not_started',
            'source' => 'manual',
        ]));

        return redirect()->route('executor.deceased_cases.show')->with('success', 'Organisation added successfully.');
    }

    public function updateOrganization(Request $request, DeceasedCaseOrganization $organization)
    {
        $this->authorizeOrganization($organization);

        $validated = $request->validate([
            'organisation_name' => 'required|string|max:255',
            'organisation_type' => 'required|string|max:255',
            'organisation_contact_name' => 'nullable|string|max:255',
            'organisation_email' => 'nullable|email|max:255',
            'organisation_address' => 'nullable|string|max:1000',
            'organisation_reference' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'policy_number' => 'nullable|string|max:255',
            'customer_number' => 'nullable|string|max:255',
            'service_address' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'preferred_channel' => 'nullable|in:letter,email,both',
            'notes' => 'nullable|string',
        ]);

        $organization->update($validated);

        return redirect()->route('executor.deceased_cases.show')->with('success', 'Organisation updated successfully.');
    }

    public function destroyOrganization(DeceasedCaseOrganization $organization)
    {
        $this->authorizeOrganization($organization);
        $organization->delete();

        return redirect()->route('executor.deceased_cases.show')->with('success', 'Organisation removed successfully.');
    }

    public function previewNotification(Request $request, DeceasedCaseOrganization $organization, DeceasedCaseNotificationService $notificationService)
    {
        $this->authorizeOrganization($organization);

        $validated = $request->validate([
            'channel' => 'required|in:letter,email',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        $preview = $notificationService->preview(
            $organization,
            $validated['channel'],
            $validated['subject'] ?? null,
            $validated['body'] ?? null
        );

        return view('executor.deceased_cases.preview', [
            'organization' => $organization->load('deceasedCase'),
            'channel' => $validated['channel'],
            'subject' => $preview['subject'],
            'body' => $preview['body'],
        ]);
    }

    public function sendEmail(Request $request, DeceasedCaseOrganization $organization, DeceasedCaseNotificationService $notificationService)
    {
        $this->authorizeOrganization($organization);

        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        $notification = $notificationService->sendEmail($organization, $validated['subject'] ?? null, $validated['body'] ?? null);

        if ($notification->delivery_status === 'missing_email') {
            return redirect()->route('executor.deceased_cases.show')->with('error', 'Organisation email is missing. Add an email before sending.');
        }

        return redirect()->route('executor.deceased_cases.show')->with('success', 'Email notification sent and logged.');
    }

    public function sendBoth(Request $request, DeceasedCaseOrganization $organization, DeceasedCaseNotificationService $notificationService)
    {
        $this->authorizeOrganization($organization);

        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        $notifications = $notificationService->sendBoth($organization, $validated['subject'] ?? null, $validated['body'] ?? null);

        if (($notifications['email']?->delivery_status) === 'missing_email') {
            return redirect()->route('executor.deceased_cases.show')->with('error', 'Organisation email is missing. Add an email before using Send Both.');
        }

        return redirect()->route('executor.deceased_cases.show')->with('success', 'Email sent with the letter PDF attached.');
    }

    public function downloadLetter(Request $request, DeceasedCaseOrganization $organization, DeceasedCaseNotificationService $notificationService)
    {
        $this->authorizeOrganization($organization);

        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        $notification = $notificationService->generatePdf($organization, $validated['subject'] ?? null, $validated['body'] ?? null);

        return Storage::disk('public')->download($notification->pdf_path, 'bereavement-notification-' . $organization->id . '.pdf');
    }

    public function markLetterSent(DeceasedCaseNotification $notification, DeceasedCaseNotificationService $notificationService)
    {
        $this->authorizeOrganization($notification->organization);
        $notificationService->markLetterSent($notification);

        return redirect()->route('executor.deceased_cases.show')->with('success', 'Letter marked as sent.');
    }

    public function logReply(Request $request, DeceasedCaseOrganization $organization, DeceasedCaseEstateMappingService $estateMappingService)
    {
        $this->authorizeOrganization($organization);

        $validated = $request->validate([
            'reply_status' => 'required|string|max:255',
            'mapping_outcome' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'received_at' => 'nullable|date',
            'summary' => 'nullable|string',
        ]);

        $reply = $organization->replies()->create(array_merge($validated, [
            'logged_by' => Auth::id(),
        ]));

        $reply = $estateMappingService->mapReply($reply);

        if (($validated['mapping_outcome'] ?? null) === 'no_account_found') {
            $organization->update(['status' => 'closed_no_account_found']);
        } elseif (array_key_exists($validated['reply_status'], DeceasedCaseNotificationService::ORGANISATION_STATUSES)) {
            $organization->update(['status' => $validated['reply_status']]);
        }

        $mappedMessage = $reply->mapped_entity_type ? ' The reply was mapped into the estate records.' : '';

        return redirect()->route('executor.deceased_cases.show')->with('success', 'Reply logged successfully.' . $mappedMessage);
    }

    private function currentCase(): DeceasedCase
    {
        return DeceasedCase::where('customer_id', ContextHelper::user()->id)->firstOrFail();
    }

    private function authorizeOrganization(?DeceasedCaseOrganization $organization): void
    {
        abort_if(!$organization || $organization->deceasedCase?->customer_id !== ContextHelper::user()->id, 403);
    }
}
