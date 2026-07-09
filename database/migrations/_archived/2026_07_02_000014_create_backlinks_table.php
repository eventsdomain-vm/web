<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backlinks', function (Blueprint $table) {
            $table->id();
            $table->string('target_url', 2048);
            $table->string('source_url', 2048);
            $table->string('anchor_text')->nullable();
            $table->unsignedTinyInteger('domain_authority')->default(0);
            $table->enum('link_type', ['dofollow', 'nofollow', 'sponsored', 'ugc'])->default('dofollow');
            $table->enum('status', ['active', 'broken', 'pending'])->default('pending');
            $table->timestamps();

            $table->index('status', 'idx_backlinks_status');
            $table->index('domain_authority', 'idx_backlinks_da');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backlinks');
    }
};
