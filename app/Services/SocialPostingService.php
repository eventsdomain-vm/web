<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EventPost;
use App\Models\PostLog;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SocialPostingService
{
    public function post(EventPost $post): void
    {
        $results = [];

        foreach ($post->platforms as $platform) {
            $results[$platform] = $this->postToPlatform($post, $platform);
        }

        $this->updatePostStatus($post, $results);
    }

    public function postToPlatform(EventPost $post, string $platform): array
    {
        $account = SocialAccount::where('user_id', $post->user_id)
            ->where('provider', $platform)
            ->first();

        if (! $account) {
            $this->logAttempt($post, $platform, false, null, 'No social account found for provider: '.$platform);

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => 'No social account found for provider: '.$platform,
            ];
        }

        $content = $post->content[$platform] ?? null;

        if (! $content) {
            $this->logAttempt($post, $platform, false, null, 'No content defined for platform: '.$platform);

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => 'No content defined for platform: '.$platform,
            ];
        }

        return match ($platform) {
            'facebook' => $this->postToFacebook($post, $account, $content),
            'instagram' => $this->postToInstagram($post, $account, $content),
            'linkedin' => $this->postToLinkedIn($post, $account, $content),
            'youtube' => $this->postToYouTube($post, $account, $content),
            default => [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => 'Unsupported platform: '.$platform,
            ],
        };
    }

    private function postToFacebook(EventPost $post, SocialAccount $account, array $content): array
    {
        try {
            $pagesResponse = Http::get('https://graph.facebook.com/v19.0/me/accounts', [
                'access_token' => $account->access_token,
            ]);

            if (! $pagesResponse->successful()) {
                $error = $pagesResponse->json('error.message', 'Failed to fetch Facebook pages');
                $this->logAttempt($post, 'facebook', false, null, $error);

                return [
                    'success' => false,
                    'post_url' => null,
                    'response' => null,
                    'error' => $error,
                ];
            }

            $pages = $pagesResponse->json('data', []);

            if (empty($pages)) {
                $error = 'No Facebook pages found for this account';
                $this->logAttempt($post, 'facebook', false, null, $error);

                return [
                    'success' => false,
                    'post_url' => null,
                    'response' => null,
                    'error' => $error,
                ];
            }

            $pageId = $pages[0]['id'];
            $pageToken = $pages[0]['access_token'];

            $payload = [
                'message' => $content['message'] ?? '',
                'access_token' => $pageToken,
            ];

            if (! empty($content['link'])) {
                $payload['link'] = $content['link'];
            }

            $response = Http::post("https://graph.facebook.com/v19.0/{$pageId}/feed", $payload);

            if ($response->successful()) {
                $postId = $response->json('id');
                $postUrl = "https://facebook.com/{$postId}";

                $reachData = $this->extractFacebookReach($response->json());

                $this->logAttempt($post, 'facebook', true, $postUrl, null, $reachData);

                return [
                    'success' => true,
                    'post_url' => $postUrl,
                    'response' => $postId,
                    'error' => null,
                ];
            }

            $error = $response->json('error.message', 'Failed to post to Facebook');
            $this->logAttempt($post, 'facebook', false, null, $error);

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $error,
            ];
        } catch (\Exception $e) {
            Log::error('Facebook posting failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage(),
            ]);

            $this->logAttempt($post, 'facebook', false, null, $e->getMessage());

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function postToInstagram(EventPost $post, SocialAccount $account, array $content): array
    {
        try {
            $igUserId = $account->provider_id;
            $accessToken = $account->access_token;

            $imageUrl = $content['image_url'] ?? null;
            if (! $imageUrl) {
                $error = 'Instagram requires an image_url';
                $this->logAttempt($post, 'instagram', false, null, $error);

                return [
                    'success' => false,
                    'post_url' => null,
                    'response' => null,
                    'error' => $error,
                ];
            }

            $caption = $content['caption'] ?? $content['message'] ?? '';

            $containerResponse = Http::post("https://graph.facebook.com/v19.0/{$igUserId}/media", [
                'image_url' => $imageUrl,
                'caption' => $caption,
                'access_token' => $accessToken,
            ]);

            if (! $containerResponse->successful()) {
                $error = $containerResponse->json('error.message', 'Failed to create Instagram media container');
                $this->logAttempt($post, 'instagram', false, null, $error);

                return [
                    'success' => false,
                    'post_url' => null,
                    'response' => null,
                    'error' => $error,
                ];
            }

            $creationId = $containerResponse->json('id');

            $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$igUserId}/media_publish", [
                'creation_id' => $creationId,
                'access_token' => $accessToken,
            ]);

            if ($publishResponse->successful()) {
                $mediaId = $publishResponse->json('id');
                $postUrl = "https://instagram.com/p/{$mediaId}";

                $this->logAttempt($post, 'instagram', true, $postUrl, null);

                return [
                    'success' => true,
                    'post_url' => $postUrl,
                    'response' => $mediaId,
                    'error' => null,
                ];
            }

            $error = $publishResponse->json('error.message', 'Failed to publish Instagram media');
            $this->logAttempt($post, 'instagram', false, null, $error);

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $error,
            ];
        } catch (\Exception $e) {
            Log::error('Instagram posting failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage(),
            ]);

            $this->logAttempt($post, 'instagram', false, null, $e->getMessage());

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function postToLinkedIn(EventPost $post, SocialAccount $account, array $content): array
    {
        try {
            $authorUrn = "urn:li:person:{$account->provider_id}";

            $payload = [
                'author' => $authorUrn,
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $content['message'] ?? '',
                        ],
                        'shareMediaCategory' => ! empty($content['link']) ? 'ARTICLE' : 'NONE',
                    ],
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ],
            ];

            if (! empty($content['link'])) {
                $payload['specificContent']['com.linkedin.ugc.ShareContent']['media'] = [
                    [
                        'status' => 'READY',
                        'originalUrl' => $content['link'],
                    ],
                ];
            }

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$account->access_token}",
                'Content-Type' => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0',
            ])->post('https://api.linkedin.com/v2/ugcPosts', $payload);

            if ($response->successful()) {
                $postId = $response->json('id');
                $postUrl = "https://linkedin.com/feed/update/{$postId}";

                $this->logAttempt($post, 'linkedin', true, $postUrl, null);

                return [
                    'success' => true,
                    'post_url' => $postUrl,
                    'response' => $postId,
                    'error' => null,
                ];
            }

            $error = $response->json('message', 'Failed to post to LinkedIn');
            $this->logAttempt($post, 'linkedin', false, null, $error);

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $error,
            ];
        } catch (\Exception $e) {
            Log::error('LinkedIn posting failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage(),
            ]);

            $this->logAttempt($post, 'linkedin', false, null, $e->getMessage());

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function postToYouTube(EventPost $post, SocialAccount $account, array $content): array
    {
        try {
            $channelId = $account->provider_id;

            $payload = [
                'snippet' => [
                    'channelId' => $channelId,
                    'textSnippet' => $content['message'] ?? '',
                ],
            ];

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$account->access_token}",
                'Content-Type' => 'application/json',
            ])->post(
                'https://www.googleapis.com/youtube/v3/communityThreads?part=snippet',
                $payload
            );

            if ($response->successful()) {
                $threadId = $response->json('id');
                $postUrl = "https://youtube.com/channel/{$channelId}/community?lb={$threadId}";

                $this->logAttempt($post, 'youtube', true, $postUrl, null);

                return [
                    'success' => true,
                    'post_url' => $postUrl,
                    'response' => $threadId,
                    'error' => null,
                ];
            }

            $error = $response->json('error.message', 'Failed to post to YouTube');
            $this->logAttempt($post, 'youtube', false, null, $error);

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $error,
            ];
        } catch (\Exception $e) {
            Log::error('YouTube posting failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage(),
            ]);

            $this->logAttempt($post, 'youtube', false, null, $e->getMessage());

            return [
                'success' => false,
                'post_url' => null,
                'response' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function extractFacebookReach(array $response): array
    {
        $reach = [];

        if (isset($response['shares']['count'])) {
            $reach['engagement_shares'] = (int) $response['shares']['count'];
        }

        if (isset($response['likes']['summary']['total_count'])) {
            $reach['engagement_likes'] = (int) $response['likes']['summary']['total_count'];
        }

        if (isset($response['comments']['summary']['total_count'])) {
            $reach['engagement_comments'] = (int) $response['comments']['summary']['total_count'];
        }

        return $reach;
    }

    private function logAttempt(
        EventPost $post,
        string $platform,
        bool $success,
        ?string $postUrl,
        ?string $error,
        array $reachData = []
    ): PostLog {
        return PostLog::create([
            'event_post_id' => $post->id,
            'platform' => $platform,
            'status' => $success ? 'success' : 'failed',
            'post_url' => $postUrl,
            'error_message' => $error,
            'reach_impressions' => $reachData['reach_impressions'] ?? null,
            'reach_reach' => $reachData['reach_reach'] ?? null,
            'engagement_likes' => $reachData['engagement_likes'] ?? 0,
            'engagement_comments' => $reachData['engagement_comments'] ?? 0,
            'engagement_shares' => $reachData['engagement_shares'] ?? 0,
        ]);
    }

    private function updatePostStatus(EventPost $post, array $results): void
    {
        $total = count($results);
        $successes = count(array_filter($results, fn (array $r) => $r['success']));

        $status = match (true) {
            $successes === $total => 'published',
            $successes === 0 => 'failed',
            default => 'partial',
        };

        $post->update(['status' => $status]);
    }
}
