<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\PublishSocialPostJob;
use App\Models\EventPost;
use Illuminate\Console\Command;

class PublishScheduledPosts extends Command
{
    protected $signature = 'social:publish-due';

    protected $description = 'Publish scheduled social posts that are due';

    public function handle(): int
    {
        $posts = EventPost::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($posts->isEmpty()) {
            $this->info('No scheduled posts due for publishing.');

            return self::SUCCESS;
        }

        $this->info("Found {$posts->count()} post(s) due for publishing.");

        foreach ($posts as $post) {
            $post->update(['status' => 'publishing']);

            PublishSocialPostJob::dispatch($post);

            $this->line("  Dispatched job for post #{$post->id} (platforms: ".implode(', ', $post->platforms).')');
        }

        $this->newLine();
        $this->info('All due posts have been dispatched.');

        return self::SUCCESS;
    }
}
