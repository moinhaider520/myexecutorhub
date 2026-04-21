<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\DeceasedCaseOrganization;
use App\Models\DeceasedCaseReply;
use App\Models\DebtAndLiability;
use App\Models\InvestmentAccount;
use App\Models\OtherAsset;
use Illuminate\Support\Str;

class DeceasedCaseEstateMappingService
{
    public function mapReply(DeceasedCaseReply $reply): DeceasedCaseReply
    {
        $organization = $reply->organization()->with('deceasedCase')->first();

        if (!$organization || !$reply->mapping_outcome) {
            return $reply;
        }

        return match ($reply->mapping_outcome) {
            'asset_found' => $this->mapAsset($reply, $organization),
            'liability_found' => $this->mapLiability($reply, $organization),
            'refund_due' => $this->mapRefund($reply, $organization),
            'no_account_found' => $this->closeNoAccountFound($reply, $organization),
            default => $reply,
        };
    }

    private function mapAsset(DeceasedCaseReply $reply, DeceasedCaseOrganization $organization): DeceasedCaseReply
    {
        $customerId = $organization->deceasedCase->customer_id;
        $amount = $reply->amount ?? 0;

        if (in_array($organization->organisation_type, ['bank', 'building_society'], true)) {
            $accountNumber = $organization->account_number ?: 'case-' . $organization->deceased_case_id . '-org-' . $organization->id;
            $asset = BankAccount::updateOrCreate(
                [
                    'created_by' => $customerId,
                    'account_number' => $accountNumber,
                ],
                [
                    'account_type' => 'Bereavement confirmed',
                    'bank_name' => $organization->organisation_name,
                    'sort_code' => 'Unknown',
                    'account_name' => $organization->deceasedCase->deceased_full_name ?: 'Deceased estate',
                    'balance' => $amount,
                ]
            );

            return $this->markMapped($reply, BankAccount::class, $asset->id);
        }

        if ($organization->organisation_type === 'investment_platform') {
            $accountNumber = $organization->account_number ?: 'case-' . $organization->deceased_case_id . '-org-' . $organization->id;
            $asset = InvestmentAccount::updateOrCreate(
                [
                    'account_number' => $accountNumber,
                ],
                [
                    'created_by' => $customerId,
                    'investment_type' => 'Bereavement confirmed',
                    'company_name' => $organization->organisation_name,
                    'balance' => $amount,
                ]
            );

            return $this->markMapped($reply, InvestmentAccount::class, $asset->id);
        }

        return $this->mapOtherAsset($reply, $organization, 'Confirmed asset');
    }

    private function mapLiability(DeceasedCaseReply $reply, DeceasedCaseOrganization $organization): DeceasedCaseReply
    {
        $customerId = $organization->deceasedCase->customer_id;
        $reference = $organization->organisation_reference
            ?: $organization->account_number
            ?: $organization->customer_number
            ?: 'case-' . $organization->deceased_case_id . '-org-' . $organization->id;

        $liability = DebtAndLiability::updateOrCreate(
            [
                'created_by' => $customerId,
                'reference_number' => $reference,
            ],
            [
                'debt_type' => Str::headline($organization->organisation_type),
                'loan_provider' => $organization->organisation_name,
                'contact_details' => $organization->organisation_email ?: ($organization->organisation_address ?: 'Not provided'),
                'amount_outstanding' => $reply->amount ?? 0,
            ]
        );

        return $this->markMapped($reply, DebtAndLiability::class, $liability->id);
    }

    private function mapRefund(DeceasedCaseReply $reply, DeceasedCaseOrganization $organization): DeceasedCaseReply
    {
        return $this->mapOtherAsset($reply, $organization, 'Refund due');
    }

    private function closeNoAccountFound(DeceasedCaseReply $reply, DeceasedCaseOrganization $organization): DeceasedCaseReply
    {
        $organization->update(['status' => 'closed_no_account_found']);

        return $reply;
    }

    private function mapOtherAsset(DeceasedCaseReply $reply, DeceasedCaseOrganization $organization, string $assetType): DeceasedCaseReply
    {
        $description = trim(implode("\n", array_filter([
            $organization->organisation_name,
            $reply->amount ? 'Amount: GBP ' . number_format((float) $reply->amount, 2) : null,
            $reply->summary,
        ])));

        $asset = OtherAsset::create([
            'asset_type' => $assetType,
            'description' => $description ?: $assetType . ' from ' . $organization->organisation_name,
            'created_by' => $organization->deceasedCase->customer_id,
        ]);

        return $this->markMapped($reply, OtherAsset::class, $asset->id);
    }

    private function markMapped(DeceasedCaseReply $reply, string $type, int $id): DeceasedCaseReply
    {
        $reply->update([
            'mapped_entity_type' => $type,
            'mapped_entity_id' => $id,
        ]);

        return $reply->fresh();
    }
}
