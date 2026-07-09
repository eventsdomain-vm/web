<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsor_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 100);
            $table->string('title', 255);
            $table->text('body')->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('action_url', 500)->nullable();
            $table->string('action_label', 100)->nullable();
            $table->string('reference_type', 50)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('dismissed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'read_at'], 'idx_sp_notif_user_read');
            $table->index('sponsor_id', 'idx_sp_notif_sponsor');
            $table->index(['reference_type', 'reference_id'], 'idx_sp_notif_reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_notifications');
    }
};
