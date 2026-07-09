<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Communication & social-posting tables: conversations, participants, messages,
 * the Laravel notifications table, and the event social-posting queue/logs.
 * Ported from the SQL dump into reproducible migrations.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['direct', 'sponsorship', 'partnership'])->default('direct');
            $table->timestamps();

            $table->index('event_id', 'idx_conversations_event_id');
            $table->index('type', 'idx_conversations_type');
        });

        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('last_read_at')->nullable();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id'], 'uk_conv_participants_conv_user');
            $table->index('user_id', 'idx_conv_participants_user_id');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->string('attachment_url', 500)->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index('conversation_id', 'idx_messages_conversation_id');
            $table->index('sender_id', 'idx_messages_sender_id');
            $table->index('created_at', 'idx_messages_created_at');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->json('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index('read_at', 'idx_notifications_read_at');
        });

        Schema::create('event_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('platforms');
            $table->json('content');
            $table->enum('status', ['draft', 'scheduled', 'publishing', 'published', 'partial', 'failed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();

            $table->index('event_id', 'idx_event_posts_event_id');
            $table->index('user_id', 'idx_event_posts_user_id');
            $table->index('status', 'idx_event_posts_status');
        });

        Schema::create('post_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_post_id')->constrained('event_posts')->cascadeOnDelete();
            $table->string('platform', 50);
            $table->enum('status', ['success', 'failed']);
            $table->text('response')->nullable();
            $table->text('error_message')->nullable();
            $table->string('post_url', 500)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('event_post_id', 'idx_post_logs_event_post_id');
            $table->index('platform', 'idx_post_logs_platform');
            $table->index('status', 'idx_post_logs_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_logs');
        Schema::dropIfExists('event_posts');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');
    }
};
