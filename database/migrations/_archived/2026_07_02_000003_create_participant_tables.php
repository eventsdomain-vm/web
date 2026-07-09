<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Generalized participant system (Task 5): one reusable participant master plus
 * a type lookup. Per-event participation (with roles and timings) lives in the
 * event_participants pivot created alongside the event tables.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Lookup of participation roles: speaker, panelist, artist, dj, team, ...
        Schema::create('participant_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 80)->unique();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Reusable person/act master, deduplicated across events.
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type', 80)->nullable();
            $table->text('bio')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('website', 500)->nullable();
            $table->json('social_links')->nullable();
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->string('company')->nullable();
            $table->softDeletes();
            $table->timestamps();

            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['name', 'bio', 'organization'], 'ft_participants_search');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
        Schema::dropIfExists('participant_types');
    }
};
