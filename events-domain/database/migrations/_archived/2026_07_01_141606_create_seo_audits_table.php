<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_audits', function (Blueprint $table) {
            $table->id();
            $table->string('auditable_type');
            $table->unsignedBigInteger('auditable_id');
            $table->string('url')->nullable();
            $table->json('results')->nullable();
            $table->integer('score')->default(0);
            $table->integer('critical_issues')->default(0);
            $table->integer('warnings')->default(0);
            $table->integer('notices')->default(0);
            $table->json('issues')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['auditable_type', 'auditable_id']);
            $table->index('score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_audits');
    }
};
