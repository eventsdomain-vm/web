<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor_teams', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->after('sponsor_id')->constrained('events')->nullOnDelete();
            $table->index('event_id', 'idx_sp_teams_event_id');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor_teams', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['event_id']);
            $table->dropIndex('idx_sp_teams_event_id');
            $table->dropColumn('event_id');
        });
    }
};
