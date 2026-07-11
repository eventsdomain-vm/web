<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('user_id');
            $table->decimal('rating', 3, 2)->default(0)->after('about');
            $table->unsignedInteger('reviews_count')->default(0)->after('rating');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['is_verified', 'rating', 'reviews_count']);
        });
    }
};
