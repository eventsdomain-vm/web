<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsor_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->nullOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject', 255)->nullable();
            $table->longText('body');
            $table->string('message_type', 50)->default('direct');
            $table->string('reference_type', 50)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_messages_sponsor_id');
            $table->index(['sender_id', 'recipient_id'], 'idx_sp_messages_participants');
            $table->index('read_at', 'idx_sp_messages_read_at');
            $table->index(['reference_type', 'reference_id'], 'idx_sp_messages_reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_messages');
    }
};
