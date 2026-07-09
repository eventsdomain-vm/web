<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->unsignedTinyInteger('image_limit');
            $table->string('analytics_level')->default('basic');
            $table->boolean('featured_badge')->default(false);
            $table->boolean('priority_listing')->default(false);
            $table->boolean('social_promotion')->default(false);
            $table->boolean('homepage_featured')->default(false);
            $table->unsignedSmallInteger('listing_duration_days')->default(90);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
