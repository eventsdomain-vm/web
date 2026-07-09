<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('database.default') === 'sqlite') {
            return;
        }

        Schema::table('sponsor_packages', function (Blueprint $table) {
            $table->dropColumn('benefits');
        });
    }

    public function down(): void
    {
        if (config('database.default') === 'sqlite') {
            return;
        }

        Schema::table('sponsor_packages', function (Blueprint $table) {
            $table->json('benefits')->nullable()->after('slots_filled');
        });
    }
};
