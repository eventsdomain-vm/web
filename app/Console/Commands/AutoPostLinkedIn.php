<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\EventPost;
use App\Models\SocialAccount;
use App\Services\LinkedInAIContentService;
use App\Services\SocialPostingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoPostLinkedIn extends Command
{
    protected $signature = 'social:auto-post-linkedin 
                            {--dry-run : Run without actually posting}
                            {--user-id= : Specific user ID to process}';

    protected $description = 'Auto-post scheduled LinkedIn content using AI';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $userId = $this->option('user-id');

        $this->info('Starting LinkedIn auto-post...');

        // Get posts scheduled for today that haven't been posted
        $query = EventPost::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->whereJsonContains('platforms', 'linkedin')
            ->with('user');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $posts = $query->get();

        if ($posts->isEmpty()) {
            $this->info('No scheduled LinkedIn posts found for today.');
            return self::SUCCESS;
        }

        $this->info("Found {$posts->count()} post(s) to process.");

        $aiService = new LinkedInAIContentService();
        $postingService = new SocialPostingService();
        $processed = 0;
        $failed = 0;

        foreach ($posts as $post) {
            $this->processPost($post, $aiService, $postingService, $dryRun, $processed, $failed);
        }

        $this->newLine();
        $this->info("Completed: {$processed} posted, {$failed} failed.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    protected function processPost(
        EventPost $post,
        LinkedInAIContentService $aiService,
        SocialPostingService $postingService,
        bool $dryRun,
        int &$processed,
        int &$failed
    ): void {
        $this->info("Processing post #{$post->id}: {$post->title}");

        // Check if user has LinkedIn account connected
        $linkedinAccount = SocialAccount::where('user_id', $post->user_id)
            ->where('provider', 'linkedin')
            ->first();

        if (!$linkedinAccount) {
            $this->warn("  No LinkedIn account connected for user {$post->user_id}");
            $failed++;
            $post->update(['status' => 'failed', 'error_message' => 'No LinkedIn account connected']);
            return;
        }

        // Generate AI content if not already provided
        $linkedinContent = $post->content['linkedin'] ?? null;

        if (!$linkedinContent || empty($linkedinContent['message'])) {
            $this->info("  Generating AI content...");

            $aiResult = $aiService->generateLinkedInPost($post->title, [
                'key_points' => $post->metadata['key_points'] ?? [],
                'target_audience' => $post->metadata['target_audience'] ?? null,
                'tone' => $post->metadata['tone'] ?? 'professional',
                'cta' => $post->metadata['cta'] ?? null,
                'industry' => $post->metadata['industry'] ?? null,
            ]);

            if (!$aiResult['success']) {
                $this->error("  AI generation failed: {$aiResult['error']}");
                $failed++;
                $post->update(['status' => 'failed', 'error_message' => 'AI generation failed: ' . $aiResult['error']]);
                return;
            }

            $linkedinContent = [
                'message' => $aiResult['content'],
                'hashtags' => $aiResult['hashtags'] ?? [],
            ];

            $post->content['linkedin'] = $linkedinContent;
            $post->save();
        }

        $this->info("  Content ready: " . strlen($linkedinContent['message']) . " chars");

        if ($dryRun) {
            $this->warn("  [DRY RUN] Would post to LinkedIn");
            $processed++;
            return;
        }

        // Post to LinkedIn
        try {
            $result = $postingService->postToPlatform($post, 'linkedin');

            if ($result['success']) {
                $this->info("  ✓ Posted successfully: {$result['post_url']}");
                $post->update([
                    'status' => 'published',
                    'published_at' => now(),
                    'platform_posts' => array_merge($post->platform_posts ?? [], [
                        'linkedin' => [
                            'post_id' => $result['response'],
                            'url' => $result['post_url'],
                            'posted_at' => now()->toISOString(),
                        ]
                    ]),
                ]);
                $processed++;
            } else {
                $this->error("  ✗ Posting failed: {$result['error']}");
                $failed++;
                $post->update(['status' => 'failed', 'error_message' => $result['error']]);
            }
        } catch (\Exception $e) {
            $this->error("  ✗ Exception: {$e->getMessage()}");
            Log::error('Auto-post LinkedIn exception', [
                'post_id' => $post->id,
                'error' => $e->getMessage(),
            ]);
            $failed++;
            $post->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
        }
    }
}