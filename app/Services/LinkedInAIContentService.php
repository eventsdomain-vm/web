<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInAIContentService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.zenmux.key') ?? config('services.openai.key') ?? env('OPENAI_API_KEY');
        $this->baseUrl = config('services.zenmux.base_url') ?? 'https://api.openai.com/v1';
        $this->model = config('services.ai.openai_model') ?? 'gpt-4o';
    }

    public function generateLinkedInPost(string $topic, array $options = []): array
    {
        $prompt = $this->buildPrompt($topic, $options);

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/chat/completions", [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $this->getSystemPrompt()],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            if (!$response->successful()) {
                Log::error('LinkedIn AI content generation failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => 'AI generation failed: ' . $response->json('error.message', 'Unknown error'),
                ];
            }

            $content = $response->json('choices.0.message.content');

            return [
                'success' => true,
                'content' => $content,
                'hashtags' => $this->extractHashtags($content),
            ];
        } catch (\Exception $e) {
            Log::error('LinkedIn AI content generation exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function reformatForLinkedIn(string $rawContent): array
    {
        $prompt = "Reformat the following content for a high-engagement LinkedIn post. 
        Use best practices: strong hook in first line, clear paragraph breaks, bullet points for readability, 
        relevant hashtags (3-5), and a clear call-to-action at the end.
        
        Raw content:
        {$rawContent}";

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/chat/completions", [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $this->getSystemPrompt()],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            if (!$response->successful()) {
                return ['success' => false, 'error' => 'Reformat failed'];
            }

            $content = $response->json('choices.0.message.content');

            return [
                'success' => true,
                'content' => $content,
                'hashtags' => $this->extractHashtags($content),
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    protected function getSystemPrompt(): string
    {
        return "You are an expert LinkedIn content strategist. Create posts that:
        1. Hook readers in the first 150 characters (before 'see more')
        2. Use short paragraphs (1-2 sentences each)
        3. Include bullet points for scannability
        4. Add 3-5 relevant hashtags at the end
        5. End with a question or call-to-action to drive comments
        6. Professional but conversational tone
        7. No emoji overuse (max 2-3 per post)
        8. Optimize for LinkedIn algorithm (native content, no external links in post)";
    }

    protected function buildPrompt(string $topic, array $options): string
    {
        $prompt = "Create a LinkedIn post about: {$topic}";

        if (!empty($options['key_points'])) {
            $prompt .= "\n\nKey points to cover:\n" . implode("\n", array_map(fn($p) => "- {$p}", $options['key_points']));
        }

        if (!empty($options['target_audience'])) {
            $prompt .= "\nTarget audience: {$options['target_audience']}";
        }

        if (!empty($options['tone'])) {
            $prompt .= "\nTone: {$options['tone']}";
        }

        if (!empty($options['cta'])) {
            $prompt .= "\nCall to action: {$options['cta']}";
        }

        if (!empty($options['industry'])) {
            $prompt .= "\nIndustry context: {$options['industry']}";
        }

        return $prompt;
    }

    protected function extractHashtags(string $content): array
    {
        preg_match_all('/#(\w+)/', $content, $matches);
        return array_unique($matches[1] ?? []);
    }
}