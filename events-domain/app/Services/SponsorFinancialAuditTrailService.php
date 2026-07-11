<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SponsorFinancialAuditTrail;

class SponsorFinancialAuditTrailService
{
    public static function log(int $sponsorId, $auditable, string $eventType, $oldValues, $newValues, ?float $amount = null): SponsorFinancialAuditTrail
    {
        return SponsorFinancialAuditTrail::create([
            'sponsor_id' => $sponsorId,
            'auditable_type' => get_class($auditable),
            'auditable_id' => $auditable->id,
            'event_type' => $eventType,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'amount' => $amount,
        ]);
    }
}
