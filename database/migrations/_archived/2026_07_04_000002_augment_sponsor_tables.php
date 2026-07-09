<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // sponsor_budgets - add approval tracking (not in CREATE TABLE)
        Schema::table('sponsor_budgets', function (Blueprint $table) {
            $table->string('status', 30)->default('active')
                ->comment('active, frozen, closed');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('notes')->nullable();

            $table->index('status', 'idx_sp_budgets_status');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_budgets', function (Blueprint $table) {
            $table->dropIndex('idx_sp_budgets_status');
            $table->dropColumn(['status', 'approved_at', 'approved_by', 'notes']);
        });
    }
};
