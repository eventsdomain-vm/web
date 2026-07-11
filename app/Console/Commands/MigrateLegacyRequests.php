<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\SponsorProposal;
use App\Models\SponsorshipRequest;
use Illuminate\Console\Command;

class MigrateLegacyRequests extends Command
{
    protected $signature = 'migrate:legacy-requests';

    protected $description = 'Migrate legacy sponsorship_requests to new sponsor_proposals';

    public function handle(): int
    {
        $legacyRequests = SponsorshipRequest::with('contract')->get();

        if ($legacyRequests->isEmpty()) {
            $this->info('No legacy requests to migrate.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($legacyRequests->count());
        $bar->start();

        $migrated = 0;
        $skipped = 0;

        foreach ($legacyRequests as $old) {
            $exists = SponsorProposal::where('event_id', $old->event_id)
                ->where('sponsor_id', $old->sponsor_id)
                ->where('package_id', $old->package_id)
                ->exists();

            if ($exists) {
                $skipped++;
                $bar->advance();

                continue;
            }

            $statusMap = [
                'pending' => 'submitted',
                'accepted' => 'agreed',
                'rejected' => 'rejected',
                'negotiating' => 'negotiating',
            ];

            $status = $statusMap[$old->status] ?? 'submitted';

            $data = [
                'event_id' => $old->event_id,
                'sponsor_id' => $old->sponsor_id,
                'package_id' => $old->package_id,
                'status' => $status,
                'message' => $old->message,
                'budget_offer' => $old->budget_offer,
                'additional_benefits' => $old->custom_proposal,
                'created_at' => $old->created_at,
                'updated_at' => $old->updated_at,
            ];

            if ($old->status === 'accepted') {
                $data['agreed_at'] = $old->updated_at;
            }

            if ($old->contract) {
                $contract = $old->contract;
                if ($contract->status === 'active') {
                    $data['status'] = 'active';
                    $data['contracted_at'] = $contract->start_date ? $contract->start_date->startOfDay() : $contract->created_at;
                } elseif ($contract->status === 'completed') {
                    $data['status'] = 'completed';
                    $data['completed_at'] = $contract->end_date ? $contract->end_date->endOfDay() : $contract->updated_at;
                    $data['contracted_at'] = $contract->start_date ? $contract->start_date->startOfDay() : $contract->created_at;
                }
                $data['budget_offer'] = $data['budget_offer'] ?? $contract->amount;
            }

            SponsorProposal::create($data);

            $migrated++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Migrated {$migrated} requests, skipped {$skipped} duplicates.");

        return self::SUCCESS;
    }
}
