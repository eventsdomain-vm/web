<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->string('category')->nullable();
            $table->enum('competition_level', ['low', 'medium', 'high'])->default('medium');
            $table->unsignedInteger('monthly_search_volume')->default(0);
            $table->unsignedTinyInteger('difficulty_score')->default(0);
            $table->enum('intent', ['informational', 'transactional', 'navigational', 'commercial'])->default('informational');
            $table->timestamps();

            $table->index('category', 'idx_keywords_category');
            $table->index('competition_level', 'idx_keywords_competition');
            $table->index('intent', 'idx_keywords_intent');
            $table->index('monthly_search_volume', 'idx_keywords_volume');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText('keyword', 'ft_keywords_search');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
