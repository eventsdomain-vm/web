<?php

declare(strict_types=1);

namespace App\Services\Sponsor;

use App\Models\Event;
use App\Models\Sponsor;
use App\Models\SponsorCampaign;
use App\Models\SponsorProposal;
use Illuminate\Support\Collection;

class AIRecommendationService
{
    public function getRecommendations(int $userId, array $filters = []): Collection
    {
        $sponsor = Sponsor::where('user_id', $userId)->first();
        $profile = $this->buildSponsorProfile($userId);

        $events = Event::query()
            ->where('status', 'live')
            ->where('start_date', '>', now());

        if (! empty($filters['industry'])) {
            $events->whereHas('category', function ($q) use ($filters) {
                $q->where('name', $filters['industry']);
            });
        }

        if (! empty($filters['location'])) {
            $events->where('city', 'like', '%'.$filters['location'].'%');
        }

        $events = $events->with(['packages', 'organizer'])->get();
        $appliedEventIds = SponsorProposal::where('sponsor_id', $userId)->pluck('event_id')->toArray();

        return $events
            ->reject(fn (Event $event) => in_array($event->id, $appliedEventIds))
            ->map(fn (Event $event) => $this->scoreEvent($event, $profile, $sponsor, $filters))
            ->sortByDesc('score')
            ->values();
    }

    private function buildSponsorProfile(int $userId): array
    {
        $sponsor = Sponsor::where('user_id', $userId)->first();
        $campaigns = SponsorCampaign::where('sponsor_id', $userId)->get();

        return [
            'industry' => $sponsor?->industry,
            'previous_roi' => $campaigns->whereNotNull('roi')->avg('roi') ?? 0,
            'campaign_count' => $campaigns->count(),
            'total_invested' => $campaigns->sum('budget'),
            'brand_name' => $sponsor?->name,
        ];
    }

    private function scoreEvent(Event $event, array $profile, ?Sponsor $sponsor, array $filters): object
    {
        $score = 50;
        $reasons = [];

        if ($profile['industry'] && strcasecmp($event->category?->name ?? '', $profile['industry']) === 0) {
            $score += 25;
            $reasons[] = 'Industry match';
        }

        if (! empty($filters['budget_max'])) {
            $maxBudget = (float) $filters['budget_max'];
            $minPrice = $event->packages->min('price') ?? 0;
            if ($minPrice <= $maxBudget) {
                $score += 15;
                $reasons[] = 'Within budget range';
            } else {
                $score -= 20;
                $reasons[] = 'May exceed budget';
            }
        }

        if ($profile['previous_roi'] > 0 && $event->packages->isNotEmpty()) {
            $score += 10;
            $reasons[] = 'Good historical ROI performance';
        }

        if (! empty($filters['location']) && stripos($event->city ?? '', $filters['location']) !== false) {
            $score += 10;
            $reasons[] = 'Location match';
        }

        if ($event->packages->isNotEmpty()) {
            $score += 5;
            $reasons[] = 'Packages available';
        }

        if ($event->expected_attendees && $event->expected_attendees > 1000) {
            $score += 5;
            $reasons[] = 'Large audience reach';
        }

        $score = max(0, min(100, $score));

        return (object) [
            'event' => $event,
            'score' => $score,
            'match_level' => $score >= 75 ? 'high' : ($score >= 50 ? 'medium' : 'low'),
            'reasons' => $reasons,
        ];
    }
}
