<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('company_name');
            $table->string('logo_path')->nullable();
            $table->string('website')->nullable();

            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_phone', 20)->nullable();

            $table->string('city')->nullable();
            $table->string('country')->default('India');

            $table->enum('budget_range', [
                'under_50k', '50k_1l', '1l_5l', '5l_25l', '25l_plus',
            ])->nullable();

            $table->enum('preferred_sponsorship_type', ['cash', 'barter', 'paid_barter'])
                  ->default('cash');

            $table->text('about')->nullable();

            $table->enum('status', ['active', 'inactive', 'pending_verification'])
                  ->default('pending_verification');

            $table->timestamps();
        });

        Schema::create('partner_industry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $table->foreignId('industry_id')->constrained()->cascadeOnDelete();
            $table->unique(['partner_id', 'industry_id']);
        });

        Schema::create('partner_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->unique(['partner_id', 'category_id']);
        });

        Schema::create('partner_city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $table->string('city');
            $table->unique(['partner_id', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_city');
        Schema::dropIfExists('partner_category');
        Schema::dropIfExists('partner_industry');
        Schema::dropIfExists('partners');
    }
};
