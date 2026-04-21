<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\DeathCertificateVerification;
use App\Models\DebtAndLiability;
use App\Models\DeceasedCase;
use App\Models\InsurancePolicy;
use App\Models\InvestmentAccount;
use App\Models\Pension;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeceasedCaseService
{
    public function createOrRefreshForCustomer(User $customer, ?DeathCertificateVerification $verification = null, ?int $openedBy = null): DeceasedCase
    {
        return DB::transaction(function () use ($customer, $verification, $openedBy) {
            $case = DeceasedCase::updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'death_certificate_verification_id' => $verification?->id,
                    'opened_by' => $openedBy,
                    'case_reference' => DeceasedCase::query()
                        ->where('customer_id', $customer->id)
                        ->value('case_reference') ?? $this->generateCaseReference($customer),
                    'status' => 'open',
                    'deceased_title' => $customer->title,
                    'deceased_first_name' => $customer->name,
                    'deceased_last_name' => $customer->lastname,
                    'deceased_full_name' => trim(($customer->title ? $customer->title . ' ' : '') . $customer->name . ' ' . ($customer->lastname ?? '')),
                    'deceased_date_of_birth' => $customer->date_of_birth,
                    'deceased_date_of_death' => $customer->date_of_death,
                    'deceased_last_address_line_1' => $customer->address,
                    'deceased_last_address_city' => $customer->city,
                    'deceased_last_address_postcode' => $customer->postal_code,
                    'marital_status' => $customer->relationship,
                    'probate_status' => 'not_started',
                    'authority_document_type' => 'death_certificate',
                    'snapshot' => [
                        'customer_email' => $customer->email,
                        'contact_number' => $customer->contact_number,
                        'profession' => $customer->profession,
                    ],
                    'opened_at' => now(),
                ]
            );

            $this->seedSuggestedOrganizations($case);

            return $case->fresh(['customer', 'organizations']);
        });
    }

    public function seedSuggestedOrganizations(DeceasedCase $case): void
    {
        $customerId = $case->customer_id;

        $suggestions = collect([
            ['organisation_name' => 'HM Revenue & Customs', 'organisation_type' => 'hmrc', 'source' => 'core_checklist'],
            ['organisation_name' => 'Department for Work and Pensions', 'organisation_type' => 'dwp', 'source' => 'core_checklist'],
            ['organisation_name' => 'Local Council', 'organisation_type' => 'council', 'source' => 'core_checklist'],
            ['organisation_name' => 'Utility Providers', 'organisation_type' => 'utility', 'source' => 'core_checklist'],
            ['organisation_name' => 'Mobile Phone Providers', 'organisation_type' => 'mobile', 'source' => 'core_checklist'],
            ['organisation_name' => 'Internet Providers', 'organisation_type' => 'internet', 'source' => 'core_checklist'],
            ['organisation_name' => 'Subscription Services', 'organisation_type' => 'subscription', 'source' => 'core_checklist'],
        ]);

        $bankSuggestions = BankAccount::query()
            ->where('created_by', $customerId)
            ->select('bank_name as organisation_name', 'account_number')
            ->get()
            ->map(fn ($row) => [
                'organisation_name' => $row->organisation_name,
                'organisation_type' => 'bank',
                'account_number' => $row->account_number,
                'source' => 'asset_bank_account',
            ]);

        $debtSuggestions = DebtAndLiability::query()
            ->where('created_by', $customerId)
            ->select('loan_provider as organisation_name', 'reference_number')
            ->get()
            ->map(fn ($row) => [
                'organisation_name' => $row->organisation_name,
                'organisation_type' => 'loan',
                'organisation_reference' => $row->reference_number,
                'source' => 'asset_debt',
            ]);

        $insuranceSuggestions = InsurancePolicy::query()
            ->where('created_by', $customerId)
            ->select('provider_name as organisation_name', 'policy_number', 'contact_details')
            ->get()
            ->map(fn ($row) => [
                'organisation_name' => $row->organisation_name,
                'organisation_type' => 'insurance',
                'policy_number' => $row->policy_number,
                'organisation_email' => $row->contact_details,
                'source' => 'asset_insurance',
            ]);

        $pensionSuggestions = Pension::query()
            ->where('created_by', $customerId)
            ->select('pension_provider as organisation_name', 'pension_reference_number')
            ->get()
            ->filter(fn ($row) => !empty($row->organisation_name))
            ->map(fn ($row) => [
                'organisation_name' => $row->organisation_name,
                'organisation_type' => 'pension',
                'organisation_reference' => $row->pension_reference_number,
                'source' => 'asset_pension',
            ]);

        $investmentSuggestions = InvestmentAccount::query()
            ->where('created_by', $customerId)
            ->select('company_name as organisation_name', 'account_number')
            ->get()
            ->map(fn ($row) => [
                'organisation_name' => $row->organisation_name,
                'organisation_type' => 'investment_platform',
                'account_number' => $row->account_number,
                'source' => 'asset_investment',
            ]);

        $propertySuggestions = Property::query()
            ->where('created_by', $customerId)
            ->select('address')
            ->get()
            ->map(fn ($row) => [
                'organisation_name' => 'Property / Mortgage Review',
                'organisation_type' => 'mortgage',
                'service_address' => $row->address,
                'source' => 'asset_property',
            ]);

        $allSuggestions = $suggestions
            ->concat($bankSuggestions)
            ->concat($debtSuggestions)
            ->concat($insuranceSuggestions)
            ->concat($pensionSuggestions)
            ->concat($investmentSuggestions)
            ->concat($propertySuggestions)
            ->filter(fn ($item) => !empty($item['organisation_name']))
            ->unique(fn ($item) => Str::lower($item['organisation_type'] . '|' . $item['organisation_name']))
            ->values();

        foreach ($allSuggestions as $suggestion) {
            $case->organizations()->firstOrCreate(
                [
                    'organisation_name' => $suggestion['organisation_name'],
                    'organisation_type' => $suggestion['organisation_type'],
                ],
                [
                    'account_number' => $suggestion['account_number'] ?? null,
                    'policy_number' => $suggestion['policy_number'] ?? null,
                    'organisation_reference' => $suggestion['organisation_reference'] ?? null,
                    'organisation_email' => $suggestion['organisation_email'] ?? null,
                    'service_address' => $suggestion['service_address'] ?? null,
                    'status' => 'suggested',
                    'source' => $suggestion['source'] ?? 'manual',
                ]
            );
        }
    }

    private function generateCaseReference(User $customer): string
    {
        return 'DC-' . str_pad((string) $customer->id, 6, '0', STR_PAD_LEFT);
    }
}
