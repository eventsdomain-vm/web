<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SponsorFinancialAuditTrail;
use App\Models\SponsorInvoice;
use App\Models\SponsorInvoiceItem;
use App\Models\SponsorPaymentSchedule;
use App\Models\SponsorPaymentTransaction;
use App\Models\SponsorshipContract;
use Illuminate\Support\Facades\DB;

class SponsorFinanceService
{
    public function createInvoice(array $data, array $items = []): SponsorInvoice
    {
        return DB::transaction(function () use ($data, $items) {
            $invoice = SponsorInvoice::create($data);

            if (! empty($items)) {
                foreach ($items as $item) {
                    $item['invoice_id'] = $invoice->id;
                    SponsorInvoiceItem::create($item);
                }

                $invoice->update([
                    'subtotal' => array_sum(array_column($items, 'total')),
                    'total' => $invoice->subtotal + $invoice->tax_amount - $invoice->discount,
                ]);
            }

            $this->logFinancialEvent($invoice->sponsor_id, $invoice, 'created', null, $invoice->toArray(), $invoice->total);

            return $invoice->fresh();
        });
    }

    public function sendInvoice(SponsorInvoice $invoice): void
    {
        $invoice->update(['status' => 'sent', 'sent_at' => now()]);
    }

    public function recordPayment(SponsorInvoice $invoice, array $data): SponsorPaymentTransaction
    {
        return DB::transaction(function () use ($invoice, $data) {
            $data['sponsor_id'] = $invoice->sponsor_id;
            $data['invoice_id'] = $invoice->id;

            $transaction = SponsorPaymentTransaction::create($data);

            $newPaid = $invoice->amount_paid + $data['amount'];
            $newStatus = $newPaid >= $invoice->total ? 'paid' : 'partially_paid';

            $invoice->update([
                'amount_paid' => $newPaid,
                'status' => $newStatus,
                'paid_at' => $newStatus === 'paid' ? now() : null,
            ]);

            if ($newStatus === 'paid') {
                $schedule = $data['schedule_id'] ?? null;
                if ($schedule) {
                    SponsorPaymentSchedule::where('id', $schedule)->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                }
            }

            $this->logFinancialEvent($invoice->sponsor_id, $invoice, 'payment_received', null, $invoice->toArray(), $data['amount']);

            return $transaction;
        });
    }

    public function createPaymentSchedule(SponsorshipContract $contract, array $installments): void
    {
        DB::transaction(function () use ($contract, $installments) {
            foreach ($installments as $i => $installment) {
                SponsorPaymentSchedule::create([
                    'contract_id' => $contract->id,
                    'installment_number' => $i + 1,
                    'amount' => $installment['amount'],
                    'currency' => $installment['currency'] ?? 'INR',
                    'due_date' => $installment['due_date'],
                    'status' => 'pending',
                ]);
            }
        });
    }

    public function getInvoiceSummary(int $sponsorId): array
    {
        $invoices = SponsorInvoice::where('sponsor_id', $sponsorId);

        return [
            'total_invoiced' => (float) $invoices->sum('total'),
            'total_paid' => (float) $invoices->sum('amount_paid'),
            'outstanding' => (float) $invoices->whereNotIn('status', ['paid', 'cancelled'])->sum(DB::raw('total - amount_paid')),
            'overdue_count' => $invoices->clone()->overdue()->count(),
            'by_status' => $invoices->clone()->selectRaw('status, COUNT(*) as count, SUM(total) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
        ];
    }

    protected function logFinancialEvent(int $sponsorId, $auditable, string $eventType, $oldValues, $newValues, ?float $amount = null): void
    {
        SponsorFinancialAuditTrail::create([
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
