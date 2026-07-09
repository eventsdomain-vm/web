<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_audience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->json('audience_types')->nullable();
            $table->json('age_groups')->nullable();
            $table->string('gender_composition')->nullable();
            $table->string('income_level')->nullable();
            $table->json('industry_alignment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_audience');
    }
};
