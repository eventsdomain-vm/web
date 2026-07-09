<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_sponsorship_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->enum('level', ['title', 'co_sponsor', 'associate', 'powered_by', 'media_partner']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_sponsorship_levels');
    }
};
