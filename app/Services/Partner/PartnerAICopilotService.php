<?php

declare(strict_types=1);

namespace App\Services\Partner;

use App\Models\Event;
use App\Models\PartnerDeal;
use App\Models\PartnerLead;

class PartnerAICopilotService
{
    public function opportunityRecommendations(int $partnerId, int $limit = 5): array
    {
        $recommendations = Event::with('category', 'organizer')
            ->where('status', 'published')
            ->where('start_date', '>', now())
            ->limit(50)
            ->get()
            ->map(function ($event) {
                $score = 50;
                $reasons = [];

                if ($event->budget_max && $event->budget_max > 100000) {
                    $score += 15;
                    $reasons[] = 'High budget event';
                }
                if ($event->expected_audience && $event->expected_audience > 5000) {
                    $score += 10;
                    $reasons[] = 'Large audience reach';
                }
                if ($event->health_score && $event->health_score > 70) {
                    $score += 10;
                    $reasons[] = 'Strong organizer health score';
                }
                if ($event->previous_sponsors) {
                    $score += 5;
                    $reasons[] = 'Has prior sponsor history';
                }

                return [
                    'event' => $event,
                    'score' => min($score, 100),
                    'reasons' => $reasons,
                ];
            })
            ->sortByDesc('score')
            ->values()
            ->take($limit)
            ->toArray();

        return $recommendations;
    }

    public function leadScoring(PartnerLead $lead): array
    {
        $score = 50;
        $factors = [];

        if ($lead->value && $lead->value > 50000) {
            $score += 15;
            $factors[] = 'High deal value';
        }
        if ($lead->priority === 'high') {
            $score += 10;
            $factors[] = 'High priority';
        }
        if ($lead->event_id) {
            $score += 10;
            $factors[] = 'Linked to specific event';
        }
        if ($lead->probability && $lead->probability > 70) {
            $score += 10;
            $factors[] = 'High conversion probability';
        }

        if ($lead->event && $lead->event->health_score && $lead->event->health_score > 70) {
            $score += 5;
            $factors[] = 'Strong event health';
        }

        return [
            'score' => min($score, 100),
            'factors' => $factors,
        ];
    }

    public function revenueForecast(int $partnerId): array
    {
        $activeDeals = PartnerDeal::where('partner_id', $partnerId)
            ->whereNotIn('stage', ['completed', 'lost'])
            ->get();

        $forecast = [
            'conservative' => 0,
            'likely' => 0,
            'optimistic' => 0,
        ];

        foreach ($activeDeals as $deal) {
            $value = $deal->deal_value ?? 0;
            $rate = $deal->commission_rate ?? 10;
            $commission = ($value * $rate) / 100;

            switch ($deal->stage) {
                case 'contract':
                case 'payment':
                    $forecast['conservative'] += $commission * 0.8;
                    $forecast['likely'] += $commission * 0.9;
                    $forecast['optimistic'] += $commission;
                    break;
                case 'negotiation':
                    $forecast['conservative'] += $commission * 0.4;
                    $forecast['likely'] += $commission * 0.6;
                    $forecast['optimistic'] += $commission * 0.8;
                    break;
                case 'proposal':
                    $forecast['conservative'] += $commission * 0.2;
                    $forecast['likely'] += $commission * 0.4;
                    $forecast['optimistic'] += $commission * 0.7;
                    break;
                default:
                    $forecast['conservative'] += $commission * 0.1;
                    $forecast['likely'] += $commission * 0.25;
                    $forecast['optimistic'] += $commission * 0.5;
            }
        }

        return $forecast;
    }
}
