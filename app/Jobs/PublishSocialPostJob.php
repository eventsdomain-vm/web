<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\EventPost;
use App\Services\SocialPostingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PublishSocialPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    public function handle(SocialPostingService $socialPostingService, EventPost $post): void
    {
        Log::info('Publishing social post', [
            'post_id' => $post->id,
            'platforms' => $post->platforms,
        ]);

        try {
            $socialPostingService->post($post);

            Log::info('Social post published successfully', [
                'post_id' => $post->id,
                'status' => $post->fresh()->status,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to publish social post', [
                'post_id' => $post->id,
                'error' => $e->getMessage(),
            ]);

            $post->update(['status' => 'failed']);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('PublishSocialPostJob failed permanently', [
            'message' => $exception->getMessage(),
        ]);
    }
}
