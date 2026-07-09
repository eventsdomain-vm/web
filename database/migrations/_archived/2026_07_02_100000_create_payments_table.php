<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Payments: a gateway-agnostic transaction record. Each row is one attempt to
 * pay for a polymorphic `payable` (first use: a SponsorshipPackage purchase,
 * linked to the resulting SponsorshipRequest). The gateway columns hold the
 * provider's order/payment identifiers; status is driven by both the browser
 * callback and the webhook (webhook is the source of truth).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // public reference (shown to users)

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // payer

            // Polymorphic target of the payment (SponsorshipPackage, later: tickets…)
            $table->string('payable_type')->nullable();
            $table->unsignedBigInteger('payable_id')->nullable();

            // Gateway linkage
            $table->string('gateway', 32)->default('razorpay'); // razorpay | stripe
            $table->string('gateway_order_id')->nullable()->unique();
            $table->string('gateway_payment_id')->nullable();
            $table->string('gateway_signature')->nullable();

            // Money
            $table->decimal('amount', 15, 2);             // grand total (incl. tax)
            $table->decimal('base_amount', 15, 2)->default(0); // pre-tax
            $table->decimal('tax_amount', 15, 2)->default(0);  // GST portion
            $table->char('currency', 3)->default('INR');

            // GST snapshot at purchase time
            $table->string('gst_number', 15)->nullable();

            $table->enum('status', [
                'created', 'pending', 'paid', 'failed', 'refunded',
            ])->default('created');

            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id', 'idx_payments_user_id');
            $table->index('status', 'idx_payments_status');
            $table->index('gateway', 'idx_payments_gateway');
            $table->index(['payable_type', 'payable_id'], 'idx_payments_payable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
