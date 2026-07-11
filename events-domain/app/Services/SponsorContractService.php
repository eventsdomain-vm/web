<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SponsorContractAmendment;
use App\Models\SponsorshipContract;
use Illuminate\Support\Facades\DB;

class SponsorContractService
{
    public function createContract(array $data): SponsorshipContract
    {
        return DB::transaction(function () use ($data) {
            $contract = SponsorshipContract::create($data);

            $contract->versions()->create([
                'version_number' => 1,
                'terms' => $data['terms'] ?? '',
                'amount' => $data['amount'] ?? 0,
                'clauses' => $data['clauses'] ?? null,
                'change_summary' => 'Initial version',
                'created_by' => $data['created_by'] ?? auth()->id(),
            ]);

            return $contract;
        });
    }

    public function updateContract(SponsorshipContract $contract, array $data): SponsorshipContract
    {
        return DB::transaction(function () use ($contract, $data) {
            $latestVersion = $contract->versions()->max('version_number') ?? 0;
            $oldData = $contract->toArray();
            $contract->update($data);

            $contract->versions()->create([
                'version_number' => $latestVersion + 1,
                'terms' => $data['terms'] ?? $contract->terms,
                'amount' => $data['amount'] ?? $contract->amount,
                'clauses' => $data['clauses'] ?? $contract->clauses,
                'change_summary' => $data['change_summary'] ?? 'Updated version',
                'created_by' => $data['updated_by'] ?? auth()->id(),
            ]);

            SponsorFinancialAuditTrailService::log(
                $contract->sponsor_id,
                $contract,
                'updated',
                $oldData,
                $contract->toArray(),
            );

            return $contract->fresh();
        });
    }

    public function createAmendment(SponsorshipContract $contract, array $data): SponsorContractAmendment
    {
        return DB::transaction(function () use ($contract, $data) {
            $data['contract_id'] = $contract->id;

            $amendment = SponsorContractAmendment::create($data);

            SponsorFinancialAuditTrailService::log(
                $contract->sponsor_id ?? $contract->sponsor_id,
                $contract,
                'amendment_added',
                null,
                $amendment->toArray(),
            );

            return $amendment;
        });
    }

    public function signAmendment(SponsorContractAmendment $amendment, int $userId): void
    {
        $amendment->update([
            'status' => 'signed',
            'signed_at' => now(),
            'signed_by' => $userId,
        ]);
    }

    public function signContract(SponsorshipContract $contract, int $userId): void
    {
        $contract->update([
            'status' => 'active',
            'signed_at' => now(),
        ]);
    }

    public function terminateContract(SponsorshipContract $contract, string $reason): void
    {
        $oldStatus = $contract->status;
        $contract->update(['status' => 'terminated']);

        SponsorFinancialAuditTrailService::log(
            $contract->sponsor_id,
            $contract,
            'terminated',
            ['status' => $oldStatus],
            ['status' => 'terminated', 'reason' => $reason],
        );
    }

    public function getContractTimeline(SponsorshipContract $contract): array
    {
        $timeline = [];

        foreach ($contract->versions as $version) {
            $timeline[] = [
                'type' => 'version',
                'date' => $version->created_at,
                'title' => "Version {$version->version_number}",
                'description' => $version->change_summary,
            ];
        }

        foreach ($contract->amendments as $amendment) {
            $timeline[] = [
                'type' => 'amendment',
                'date' => $amendment->created_at,
                'title' => $amendment->title,
                'description' => $amendment->description,
                'status' => $amendment->status,
            ];
        }

        usort($timeline, fn ($a, $b) => $b['date']->timestamp <=> $a['date']->timestamp);

        return $timeline;
    }
}
