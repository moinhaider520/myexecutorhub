<?php

namespace App\Services;

use App\Models\DeceasedCase;
use App\Models\DeceasedCaseNotification;
use App\Models\DeceasedCaseOrganization;
use App\Models\NotificationTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeceasedCaseNotificationService
{
    public const ORGANISATION_TYPES = [
        'bank' => 'Bank / Building Society',
        'building_society' => 'Building Society',
        'credit_card' => 'Credit Card',
        'loan' => 'Loan / Lender',
        'mortgage' => 'Mortgage Provider',
        'utility' => 'Utility Provider',
        'council' => 'Council',
        'hmrc' => 'HMRC',
        'dwp' => 'DWP',
        'pension' => 'Pension Provider',
        'insurance' => 'Insurance Provider',
        'mobile' => 'Mobile Phone Provider',
        'internet' => 'Internet Provider',
        'landlord' => 'Landlord / Housing Association',
        'investment_platform' => 'Investment / Share Platform',
        'subscription' => 'Subscription Service',
        'other' => 'Other',
    ];

    public const ORGANISATION_STATUSES = [
        'not_started' => 'Not started',
        'suggested' => 'Suggested',
        'ready_to_send' => 'Ready to send',
        'sent' => 'Sent',
        'awaiting_reply' => 'Awaiting reply',
        'reply_received' => 'Reply received',
        'more_info_required' => 'More info required',
        'completed' => 'Completed',
        'closed_no_account_found' => 'Closed - no account found',
    ];

    public function preview(DeceasedCaseOrganization $organization, string $channel, ?string $subject = null, ?string $body = null): array
    {
        $template = $this->resolveTemplate($organization->organisation_type, $channel);
        $payload = $this->buildMergePayload($organization->deceasedCase, $organization);

        return [
            'template' => $template,
            'payload' => $payload,
            'subject' => $this->renderText($subject ?? $template->subject_template, $payload),
            'body' => $this->renderText($body ?? $template->body_template, $payload),
        ];
    }

    public function createDraft(DeceasedCaseOrganization $organization, string $channel, ?string $subject = null, ?string $body = null): DeceasedCaseNotification
    {
        $preview = $this->preview($organization, $channel, $subject, $body);

        return DeceasedCaseNotification::create([
            'deceased_case_organization_id' => $organization->id,
            'notification_template_id' => $preview['template']->id,
            'created_by' => Auth::id(),
            'channel' => $channel,
            'delivery_status' => 'draft',
            'subject_rendered' => $preview['subject'],
            'body_rendered' => $preview['body'],
            'merge_payload' => $preview['payload'],
        ]);
    }

    public function sendEmail(DeceasedCaseOrganization $organization, ?string $subject = null, ?string $body = null): DeceasedCaseNotification
    {
        $notification = $this->createDraft($organization, 'email', $subject, $body);

        if (!$organization->organisation_email) {
            $notification->update(['delivery_status' => 'missing_email']);

            return $notification;
        }

        Mail::raw($notification->body_rendered ?? '', function ($message) use ($organization, $notification) {
            $message->to($organization->organisation_email)
                ->subject($notification->subject_rendered ?: 'Bereavement notification');
        });

        $notification->update([
            'delivery_status' => 'sent',
            'sent_at' => now(),
        ]);

        $organization->update([
            'status' => 'sent',
            'preferred_channel' => 'email',
            'last_sent_at' => now(),
        ]);

        return $notification->fresh();
    }

    public function sendBoth(DeceasedCaseOrganization $organization, ?string $subject = null, ?string $body = null): array
    {
        $emailNotification = $this->createDraft($organization, 'email', $subject, $body);

        if (!$organization->organisation_email) {
            $emailNotification->update(['delivery_status' => 'missing_email']);

            return [
                'email' => $emailNotification,
                'letter' => null,
            ];
        }

        $letterNotification = $this->generatePdf($organization, $subject, $body);
        $attachmentPath = Storage::disk('public')->path($letterNotification->pdf_path);

        Mail::raw($emailNotification->body_rendered ?? '', function ($message) use ($organization, $emailNotification, $attachmentPath) {
            $message->to($organization->organisation_email)
                ->subject($emailNotification->subject_rendered ?: 'Bereavement notification')
                ->attach($attachmentPath, [
                    'as' => 'bereavement-notification.pdf',
                    'mime' => 'application/pdf',
                ]);
        });

        $emailNotification->update([
            'delivery_status' => 'sent',
            'sent_at' => now(),
        ]);

        $letterNotification->update([
            'delivery_status' => 'sent',
            'sent_at' => now(),
        ]);

        $organization->update([
            'status' => 'sent',
            'preferred_channel' => 'both',
            'last_sent_at' => now(),
        ]);

        return [
            'email' => $emailNotification,
            'letter' => $letterNotification,
        ];
    }

    public function generatePdf(DeceasedCaseOrganization $organization, ?string $subject = null, ?string $body = null): DeceasedCaseNotification
    {
        $notification = $this->createDraft($organization, 'letter', $subject, $body);

        $pdf = Pdf::loadView('pdf.deceased_case_notification', [
            'notification' => $notification,
            'organization' => $organization,
            'deceasedCase' => $organization->deceasedCase,
        ]);

        $path = 'deceased-case-notifications/case-' . $organization->deceased_case_id . '/notification-' . $notification->id . '.pdf';
        Storage::disk('public')->put($path, $pdf->output());

        $notification->update([
            'delivery_status' => 'generated',
            'pdf_path' => $path,
        ]);

        $organization->update([
            'status' => 'ready_to_send',
            'preferred_channel' => 'letter',
        ]);

        return $notification->fresh();
    }

    public function markLetterSent(DeceasedCaseNotification $notification): DeceasedCaseNotification
    {
        $notification->update([
            'delivery_status' => 'sent',
            'sent_at' => now(),
        ]);

        $notification->organization?->update([
            'status' => 'sent',
            'preferred_channel' => 'letter',
            'last_sent_at' => now(),
        ]);

        return $notification->fresh();
    }

    public function buildMergePayload(DeceasedCase $case, DeceasedCaseOrganization $organization): array
    {
        $executor = Auth::user();

        return [
            'deceased_full_name' => $case->deceased_full_name,
            'deceased_title' => $case->deceased_title,
            'deceased_first_name' => $case->deceased_first_name,
            'deceased_last_name' => $case->deceased_last_name,
            'deceased_date_of_birth' => $case->deceased_date_of_birth?->format('Y-m-d'),
            'deceased_date_of_death' => $case->deceased_date_of_death?->format('Y-m-d'),
            'deceased_last_address_line_1' => $case->deceased_last_address_line_1,
            'deceased_last_address_line_2' => $case->deceased_last_address_line_2,
            'deceased_last_address_city' => $case->deceased_last_address_city,
            'deceased_last_address_postcode' => $case->deceased_last_address_postcode,
            'deceased_national_insurance_number' => $case->deceased_national_insurance_number,
            'deceased_case_reference' => $case->case_reference,
            'executor_full_name' => trim(($executor->name ?? '') . ' ' . ($executor->lastname ?? '')),
            'executor_address_line_1' => $executor->address ?? null,
            'executor_address_line_2' => null,
            'executor_city' => $executor->city ?? null,
            'executor_postcode' => $executor->postal_code ?? null,
            'executor_email' => $executor->email ?? null,
            'executor_phone' => $executor->contact_number ?? $executor->phone_number ?? null,
            'executor_role' => $executor->how_acting ?? 'Executor',
            'organisation_name' => $organization->organisation_name,
            'organisation_type' => Arr::get(self::ORGANISATION_TYPES, $organization->organisation_type, $organization->organisation_type),
            'organisation_contact_name' => $organization->organisation_contact_name,
            'organisation_address' => $organization->organisation_address,
            'organisation_email' => $organization->organisation_email,
            'organisation_reference' => $organization->organisation_reference,
            'account_number' => $organization->account_number,
            'policy_number' => $organization->policy_number,
            'customer_number' => $organization->customer_number,
            'service_address' => $organization->service_address,
            'probate_status' => str_replace('_', ' ', $case->probate_status ?? 'not_started'),
            'grant_issue_date' => $case->grant_issue_date?->format('Y-m-d'),
            'letters_of_administration_issue_date' => $case->letters_of_administration_issue_date?->format('Y-m-d'),
            'authority_document_type' => str_replace('_', ' ', $case->authority_document_type ?? 'death_certificate'),
            'today_date' => now()->format('Y-m-d'),
            'case_manager_name' => trim(($executor->name ?? '') . ' ' . ($executor->lastname ?? '')),
            'case_reference' => $case->case_reference,
        ];
    }

    private function resolveTemplate(string $organisationType, string $channel): NotificationTemplate
    {
        $template = NotificationTemplate::query()
            ->where('organisation_type', $organisationType)
            ->where('channel', $channel)
            ->where('is_active', true)
            ->first();

        if ($template) {
            return $template;
        }

        return NotificationTemplate::create([
            'organisation_type' => $organisationType,
            'channel' => $channel,
            'name' => Arr::get(self::ORGANISATION_TYPES, $organisationType, Str::headline($organisationType)) . ' ' . ucfirst($channel),
            'subject_template' => $channel === 'email'
                ? 'Bereavement notification for {{deceased_full_name}} - {{case_reference}}'
                : null,
            'body_template' => $this->defaultTemplateBody($organisationType),
            'is_default' => true,
            'is_active' => true,
        ]);
    }

    private function renderText(?string $text, array $payload): string
    {
        $text ??= '';

        foreach ($payload as $key => $value) {
            $text = str_replace('{{' . $key . '}}', (string) ($value ?? ''), $text);
        }

        return $text;
    }

    private function defaultTemplateBody(string $organisationType): string
    {
        $requests = match ($organisationType) {
            'bank', 'building_society' => ['date of death balance', 'confirmation the account has been frozen', 'interest accrued', 'sole or joint account details', 'bereavement procedure', 'closure or release process'],
            'credit_card', 'loan' => ['balance at the date of death', 'whether interest and charges have stopped', 'settlement process', 'whether any insurance is linked to the debt'],
            'mortgage' => ['outstanding mortgage balance', 'redemption statement', 'monthly payments due', 'whether life cover is linked to the mortgage'],
            'utility' => ['final bill', 'refund or debit balance', 'account closure or transfer options', 'any meter readings required'],
            'council' => ['council tax status', 'rebate or balance', 'single occupancy changes if relevant'],
            'hmrc' => ['tax due or refund', 'whether a final return is needed', 'PAYE information', 'estate administration tax steps'],
            'dwp' => ['benefit overpayment', 'amounts recoverable', 'any funeral or death-related payments'],
            'pension' => ['death benefit', 'lump sum', 'nominee or beneficiary process', 'required claim documents'],
            'insurance' => ['claim value', 'claim process', 'policy status', 'surrender value if applicable'],
            'subscription', 'mobile', 'internet' => ['account closure', 'any refund due', 'copies of invoices if needed'],
            default => ['any account, policy, balance, refund, or liability held in the deceased person\'s name', 'your bereavement process and required documents'],
        };

        $requestLines = collect($requests)->map(fn ($item) => '- ' . $item)->implode("\n");

        return "Dear {{organisation_name}},\n\n"
            . "I am writing to notify you of the death of {{deceased_full_name}}.\n\n"
            . "Deceased details:\n"
            . "Name: {{deceased_full_name}}\n"
            . "Date of birth: {{deceased_date_of_birth}}\n"
            . "Date of death: {{deceased_date_of_death}}\n"
            . "Last address: {{deceased_last_address_line_1}}, {{deceased_last_address_city}}, {{deceased_last_address_postcode}}\n"
            . "Case reference: {{case_reference}}\n\n"
            . "Please confirm the following:\n"
            . $requestLines
            . "\n\n"
            . "Executor details:\n"
            . "{{executor_full_name}}\n"
            . "{{executor_email}}\n"
            . "{{executor_phone}}\n\n"
            . "Please advise if you require any further information or documents.\n\n"
            . "Yours faithfully,\n"
            . "{{executor_full_name}}";
    }
}
