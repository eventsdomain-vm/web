<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crawl_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('target_url', 2048);
            $table->enum('status', ['pending', 'running', 'completed', 'failed'])->default('pending');
            $table->unsignedSmallInteger('response_code')->nullable();
            $table->string('page_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('headers_found')->nullable();
            $table->json('links_found')->nullable();
            $table->json('errors')->nullable();
            $table->timestamps();

            $table->index('status', 'idx_crawl_jobs_status');
            $table->index('created_at', 'idx_crawl_jobs_created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crawl_jobs');
    }
};
