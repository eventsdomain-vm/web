<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorBudget;
use App\Models\SponsorCampaign;
use App\Models\SponsorInvoice;
use App\Models\SponsorProposal;
use App\Models\SponsorshipContract;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        $sponsor = Sponsor::where('user_id', $userId)->first();

        $reports = $sponsor
            ? $sponsor->documents()->where('type', 'report')->latest()->get()
            : collect();

        return view('sponsor.reports.index', compact('reports'));
    }

    public function show(string $type): View
    {
        $userId = auth()->id();
        $data = $this->buildReportData($userId, $type);

        return view('sponsor.reports.show', compact('data', 'type'));
    }

    public function export(string $type): StreamedResponse
    {
        $userId = auth()->id();
        $data = $this->buildReportData($userId, $type);
        $filename = "sponsorship-{$type}-report-".now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, array_keys($data['rows'][0] ?? []));
            foreach ($data['rows'] as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    private function buildReportData(int $userId, string $type): array
    {
        return match ($type) {
            'financial' => $this->financialReport($userId),
            'campaign' => $this->campaignReport($userId),
            'roi' => $this->roiReport($userId),
            'contract' => $this->contractReport($userId),
            'invoice' => $this->invoiceReport($userId),
            'budget' => $this->budgetReport($userId),
            default => ['rows' => [], 'summary' => [], 'labels' => []],
        };
    }

    private function financialReport(int $userId): array
    {
        $proposals = SponsorProposal::where('sponsor_id', $userId)->with('event')->get();
        $rows = $proposals->map(fn ($p) => [
            'Event' => $p->event?->title ?? 'N/A',
            'Status' => $p->status_label ?? $p->status,
            'Budget Offered' => (float) ($p->budget_offer ?? 0),
            'Created' => $p->created_at?->format('Y-m-d'),
        ])->toArray();

        return [
            'rows' => $rows,
            'summary' => [
                'Total Proposals' => $proposals->count(),
                'Total Value' => $proposals->sum('budget_offer'),
                'Average Offer' => $proposals->avg('budget_offer'),
            ],
            'labels' => ['Event', 'Status', 'Budget Offered', 'Created'],
        ];
    }

    private function campaignReport(int $userId): array
    {
        $campaigns = SponsorCampaign::where('sponsor_id', $userId)->with('event')->get();
        $rows = $campaigns->map(fn ($c) => [
            'Campaign' => $c->event?->title ?? 'N/A',
            'Status' => $c->status,
            'Progress' => $c->progress.'%',
            'ROI' => $c->roi ? $c->roi.'%' : 'N/A',
            'Budget' => (float) ($c->budget ?? 0),
            'Start' => $c->start_date?->format('Y-m-d'),
            'End' => $c->end_date?->format('Y-m-d'),
        ])->toArray();

        return [
            'rows' => $rows,
            'summary' => [
                'Total Campaigns' => $campaigns->count(),
                'Active' => $campaigns->where('status', 'active')->count(),
                'Completed' => $campaigns->where('status', 'completed')->count(),
                'Avg ROI' => $campaigns->avg('roi'),
            ],
            'labels' => ['Campaign', 'Status', 'Progress', 'ROI', 'Budget', 'Start', 'End'],
        ];
    }

    private function roiReport(int $userId): array
    {
        $campaigns = SponsorCampaign::where('sponsor_id', $userId)
            ->whereNotNull('roi')->with('event')->get();

        $rows = $campaigns->map(fn ($c) => [
            'Campaign' => $c->event?->title ?? 'N/A',
            'ROI' => $c->roi.'%',
            'Budget' => (float) ($c->budget ?? 0),
            'Estimated Value' => $c->budget ? (($c->roi / 100 + 1) * $c->budget) : 0,
            'Status' => $c->status,
        ])->toArray();

        return [
            'rows' => $rows,
            'summary' => [
                'Campaigns with ROI' => $campaigns->count(),
                'Average ROI' => round($campaigns->avg('roi'), 2).'%',
                'Total Investment' => $campaigns->sum('budget'),
                'Top ROI' => round($campaigns->max('roi'), 2).'%',
            ],
            'labels' => ['Campaign', 'ROI', 'Budget', 'Estimated Value', 'Status'],
        ];
    }

    private function contractReport(int $userId): array
    {
        $contracts = SponsorshipContract::whereHas('request', fn ($q) => $q->where('sponsor_id', $userId))
            ->get();

        $rows = $contracts->map(fn ($c) => [
            'Contract' => $c->title ?? 'N/A',
            'Status' => $c->status,
            'Value' => (float) ($c->value ?? 0),
            'Signed' => $c->signed_at?->format('Y-m-d'),
            'Expires' => $c->expires_at?->format('Y-m-d'),
        ])->toArray();

        return [
            'rows' => $rows,
            'summary' => [
                'Total Contracts' => $contracts->count(),
                'Active' => $contracts->where('status', 'active')->count(),
                'Total Value' => $contracts->sum('value'),
            ],
            'labels' => ['Contract', 'Status', 'Value', 'Signed', 'Expires'],
        ];
    }

    private function invoiceReport(int $userId): array
    {
        $sponsor = Sponsor::where('user_id', $userId)->first();
        $invoices = $sponsor ? SponsorInvoice::where('sponsor_id', $sponsor->id)->get() : collect();

        $rows = $invoices->map(fn ($i) => [
            'Invoice' => $i->invoice_number ?? 'N/A',
            'Status' => $i->status,
            'Total' => (float) $i->total,
            'Paid' => (float) ($i->amount_paid ?? 0),
            'Due' => $i->due_date?->format('Y-m-d'),
            'Paid At' => $i->paid_at?->format('Y-m-d'),
        ])->toArray();

        return [
            'rows' => $rows,
            'summary' => [
                'Total Invoices' => $invoices->count(),
                'Paid' => $invoices->where('status', 'paid')->count(),
                'Overdue' => $invoices->where('status', 'overdue')->count(),
                'Total Amount' => $invoices->sum('total'),
                'Total Paid' => $invoices->sum('amount_paid'),
            ],
            'labels' => ['Invoice', 'Status', 'Total', 'Paid', 'Due', 'Paid At'],
        ];
    }

    private function budgetReport(int $userId): array
    {
        $budgets = SponsorBudget::where('sponsor_id', $userId)->get();
        $rows = $budgets->map(fn ($b) => [
            'Fiscal Year' => $b->fiscal_year,
            'Total Budget' => (float) ($b->total_budget ?? 0),
            'Allocated' => (float) ($b->allocated ?? 0),
            'Spent' => (float) ($b->spent ?? 0),
            'Remaining' => (float) ($b->remaining ?? 0),
        ])->toArray();

        return [
            'rows' => $rows,
            'summary' => [
                'Years' => $budgets->count(),
                'Total Budgeted' => $budgets->sum('total_budget'),
                'Total Spent' => $budgets->sum('spent'),
                'Total Remaining' => $budgets->sum('remaining'),
            ],
            'labels' => ['Fiscal Year', 'Total Budget', 'Allocated', 'Spent', 'Remaining'],
        ];
    }
}
