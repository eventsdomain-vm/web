<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPost;
use App\Services\LinkedInAIContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialPostAIController extends Controller
{
    public function generate(Request $request, Event $event): JsonResponse
    {
        $this->authorize('update', $event);

        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:500',
            'key_points' => 'nullable|array',
            'key_points.*' => 'string|max:200',
            'target_audience' => 'nullable|string|max:200',
            'tone' => 'nullable|in:professional,casual,enthusiastic,inspirational,educational',
            'cta' => 'nullable|string|max:200',
            'industry' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $aiService = new LinkedInAIContentService();

        $result = $aiService->generateLinkedInPost($request->topic, [
            'key_points' => $request->key_points ?? [],
            'target_audience' => $request->target_audience,
            'tone' => $request->tone ?? 'professional',
            'cta' => $request->cta,
            'industry' => $request->industry,
        ]);

        if (!$result['success']) {
            return response()->json(['error' => $result['error']], 500);
        }

        return response()->json([
            'success' => true,
            'content' => $result['content'],
            'hashtags' => $result['hashtags'],
        ]);
    }

    public function reformat(Request $request, Event $event): JsonResponse
    {
        $this->authorize('update', $event);

        $validator = Validator::make($request->all(), [
            'raw_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $aiService = new LinkedInAIContentService();
        $result = $aiService->reformatForLinkedIn($request->raw_content);

        if (!$result['success']) {
            return response()->json(['error' => $result['error']], 500);
        }

        return response()->json([
            'success' => true,
            'content' => $result['content'],
            'hashtags' => $result['hashtags'],
        ]);
    }

    public function autoSchedule(Request $request, Event $event): JsonResponse
    {
        $this->authorize('update', $event);

        $validator = Validator::make($request->all(), [
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'in:facebook,linkedin,instagram,youtube',
            'content' => 'required|array',
            'content.linkedin.text' => 'nullable|string|max:3000',
            'scheduled_at' => 'required|date|after:now',
            'auto_generate' => 'boolean',
            'topic' => 'nullable|string|max:500',
            'key_points' => 'nullable|array',
            'key_points.*' => 'string|max:200',
            'target_audience' => 'nullable|string|max:200',
            'tone' => 'nullable|in:professional,casual,enthusiastic,inspirational,educational',
            'cta' => 'nullable|string|max:200',
            'industry' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $content = $request->input('content');
        $platforms = $request->input('platforms');

        // Auto-generate LinkedIn content if requested
        if ($request->boolean('auto_generate') && in_array('linkedin', $platforms)) {
            $aiService = new LinkedInAIContentService();
            $result = $aiService->generateLinkedInPost($request->topic ?? $event->title, [
                'key_points' => $request->key_points ?? [],
                'target_audience' => $request->target_audience,
                'tone' => $request->tone ?? 'professional',
                'cta' => $request->cta,
                'industry' => $request->industry ?? $event->category->name ?? null,
            ]);

            if ($result['success']) {
                $content['linkedin'] = [
                    'message' => $result['content'],
                    'hashtags' => $result['hashtags'] ?? [],
                ];
            }
        }

        $post = EventPost::create([
            'event_id' => $event->id,
            'user_id' => $request->user()->id,
            'platforms' => $platforms,
            'content' => $content,
            'status' => 'scheduled',
            'scheduled_at' => $request->input('scheduled_at'),
            'metadata' => [
                'auto_generated' => $request->boolean('auto_generate'),
                'topic' => $request->topic,
                'key_points' => $request->key_points ?? [],
                'target_audience' => $request->target_audience,
                'tone' => $request->tone ?? 'professional',
                'cta' => $request->cta,
                'industry' => $request->industry,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post scheduled for ' . $request->input('scheduled_at') . '.',
            'post_id' => $post->id,
        ]);
    }
}