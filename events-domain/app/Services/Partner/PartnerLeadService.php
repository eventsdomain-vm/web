<?php

declare(strict_types=1);

namespace App\Services\Partner;

use App\Models\PartnerActivityLog;
use App\Models\PartnerLead;
use Illuminate\Support\Facades\Auth;

class PartnerLeadService
{
    public function list(int $partnerId, array $filters = [])
    {
        $query = PartnerLead::with(['sponsor', 'event', 'assignedTo'])
            ->where('partner_id', $partnerId);

        if (! empty($filters['stage'])) {
            $query->where('stage', $filters['stage']);
        }
        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        if (! empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }
        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('notes', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->orderByDesc('created_at')->paginate(20);
    }

    public function create(int $partnerId, array $data): PartnerLead
    {
        $data['partner_id'] = $partnerId;
        $data['created_by'] = Auth::id();
        $data['assigned_to'] ??= Auth::id();

        $lead = PartnerLead::create($data);

        $this->log($partnerId, 'created', $lead);

        return $lead;
    }

    public function updateStage(PartnerLead $lead, string $stage, ?string $lostReason = null): PartnerLead
    {
        $lead->stage = $stage;
        if ($stage === 'won') {
            $lead->converted_at = now();
        }
        if ($stage === 'lost') {
            $lead->lost_reason = $lostReason;
        }
        $lead->save();

        $this->log($lead->partner_id, 'stage_changed', $lead, ['from' => $lead->getOriginal('stage'), 'to' => $stage]);

        return $lead;
    }

    protected function log(int $partnerId, string $event, $subject, array $extra = []): void
    {
        PartnerActivityLog::create([
            'partner_id' => $partnerId,
            'causer_id' => Auth::id(),
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'event' => $event,
            'properties' => $extra,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
