<?php

declare(strict_types=1);

namespace App\Services\Partner;

use App\Models\PartnerActivityLog;
use App\Models\PartnerDeal;
use App\Models\PartnerLead;
use Illuminate\Support\Facades\Auth;

class PartnerDealService
{
    public function list(int $partnerId, array $filters = [])
    {
        $query = PartnerDeal::with(['sponsor', 'event', 'lead'])
            ->where('partner_id', $partnerId);

        if (! empty($filters['stage'])) {
            $query->where('stage', $filters['stage']);
        }
        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('notes', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->orderByDesc('created_at')->paginate(20);
    }

    public function create(int $partnerId, array $data): PartnerDeal
    {
        $data['partner_id'] = $partnerId;

        if (! empty($data['lead_id'])) {
            $lead = PartnerLead::find($data['lead_id']);
            if ($lead && $lead->stage !== 'won') {
                $lead->stage = 'won';
                $lead->converted_at = now();
                $lead->save();
            }
        }

        $deal = PartnerDeal::create($data);

        $this->log($partnerId, 'created', $deal);

        return $deal;
    }

    public function updateStage(PartnerDeal $deal, string $stage): PartnerDeal
    {
        $deal->stage = $stage;
        if (in_array($stage, ['completed', 'lost'])) {
            $deal->closed_at = now();
        }
        $deal->save();

        $this->log($deal->partner_id, 'stage_changed', $deal, [
            'from' => $deal->getOriginal('stage'),
            'to' => $stage,
        ]);

        return $deal;
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
