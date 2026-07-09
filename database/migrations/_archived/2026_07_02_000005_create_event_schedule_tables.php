<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Scheduling source-of-truth (Task 4): an event has many dates (single day,
 * multi-day, or future recurring), many venues (physical/virtual/hybrid), and
 * many stages/sessions. Participants attach per-event via the pivot here.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Occurrence dates. Supports single/multi-day now, recurrence later.
        Schema::create('event_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('label', 150)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('timezone', 64)->nullable();
            $table->boolean('all_day')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('recurrence_rule', 255)->nullable(); // RFC 5545 RRULE (future)
            $table->date('recurrence_until')->nullable();
            $table->timestamps();

            $table->index('event_id', 'idx_event_dates_event_id');
            $table->index(['event_id', 'start_date', 'start_time'], 'idx_event_dates_event_start');
            $table->index('start_date', 'idx_event_dates_start_date');
        });

        // Location(s). A hybrid event may have both a physical and virtual row.
        Schema::create('event_venues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->enum('venue_type', ['physical', 'virtual', 'hybrid'])->default('physical');
            $table->string('venue_name')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('virtual_url', 500)->nullable();
            $table->string('virtual_platform', 100)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_event_venues_event_id');
            $table->index(['city', 'country'], 'idx_event_venues_city_country');
            $table->index(['event_id', 'is_primary'], 'idx_event_venues_primary');
        });

        // Physical/virtual rooms or stages a session can be assigned to.
        Schema::create('event_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_venue_id')->nullable()
                ->constrained('event_venues')->nullOnDelete();
            $table->string('name', 150);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_event_stages_event');
        });

        // Timetable sessions. References a date + stage + (optional) participant;
        // keeps free-text speaker as a fallback for imported data.
        Schema::create('event_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_date_id')->nullable()
                ->constrained('event_dates')->nullOnDelete();
            $table->foreignId('stage_id')->nullable()
                ->constrained('event_stages')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('speaker')->nullable(); // legacy/import fallback
            $table->string('venue')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_schedule_event');
            $table->index('event_date_id', 'idx_schedule_date');
            $table->index('stage_id', 'idx_schedule_stage');
        });

        // Per-event participation with role and performance timing.
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('event_date_id')->nullable()
                ->constrained('event_dates')->nullOnDelete();
            $table->string('role_label', 150)->nullable();
            $table->string('session_title')->nullable();
            $table->dateTime('performance_start')->nullable();
            $table->dateTime('performance_end')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['event_id', 'participant_id', 'participant_type_id'], 'uk_event_participants');
            $table->index('participant_id', 'idx_ep_participant');
            $table->index('participant_type_id', 'idx_ep_type');
            $table->index(['event_id', 'sort_order'], 'idx_ep_event_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_participants');
        Schema::dropIfExists('event_schedule');
        Schema::dropIfExists('event_stages');
        Schema::dropIfExists('event_venues');
        Schema::dropIfExists('event_dates');
    }
};
