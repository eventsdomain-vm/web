<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Jobs\PublishSocialPostJob;
use App\Models\Event;
use App\Models\EventPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SocialPostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = EventPost::where('user_id', $request->user()->id)
            ->with('event:id,title,slug,cover_image')
            ->with('logs')
            ->latest()
            ->paginate(20);

        $rp = $request->user()->hasRole('partner') ? 'partner' : 'organizer';

        return view($rp . '.social.posts-index', compact('posts', 'rp'));
    }

    public function show(EventPost $post): View
    {
        $this->authorize('view', $post);

        $post->load(['event:id,title,slug,cover_image,start_date,end_date', 'logs']);

        $rp = auth()->user()->hasRole('partner') ? 'partner' : 'organizer';

        return view($rp . '.social.posts-show', compact('post', 'rp'));
    }

    public function store(Request $request, Event $event): JsonResponse
    {
        $this->authorize('update', $event);

        $validator = Validator::make($request->all(), [
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'in:facebook,linkedin,instagram,youtube',
            'content' => 'required|array',
            'content.facebook.text' => 'nullable|string|max:63206',
            'content.linkedin.text' => 'nullable|string|max:3000',
            'content.instagram.text' => 'nullable|string|max:2200',
            'content.youtube.title' => 'nullable|string|max:100',
            'content.youtube.description' => 'nullable|string|max:5000',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = $request->filled('scheduled_at') ? 'scheduled' : 'draft';

        $post = EventPost::create([
            'event_id' => $event->id,
            'user_id' => $request->user()->id,
            'platforms' => $request->input('platforms'),
            'content' => $request->input('content'),
            'status' => $status,
            'scheduled_at' => $request->input('scheduled_at'),
        ]);

        if ($status === 'draft' && ! $request->filled('scheduled_at')) {
            return response()->json([
                'success' => true,
                'message' => 'Post saved as draft.',
                'post_id' => $post->id,
            ]);
        }

        if ($status === 'scheduled') {
            PublishSocialPostJob::dispatch($post)
                ->delay(now()->parse($request->input('scheduled_at')));

            return response()->json([
                'success' => true,
                'message' => 'Post scheduled for '.$request->input('scheduled_at').'.',
                'post_id' => $post->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post saved as draft. Click publish to post now.',
            'post_id' => $post->id,
        ]);
    }

    public function publish(Request $request, EventPost $post): JsonResponse
    {
        $this->authorize('update', $post->event);

        if ($post->status === 'published') {
            return response()->json(['message' => 'Post is already published.'], 422);
        }

        $post->update(['status' => 'publishing']);

        PublishSocialPostJob::dispatch($post);

        return response()->json([
            'success' => true,
            'message' => 'Publishing to '.implode(', ', $post->platforms).'...',
        ]);
    }

    public function destroy(Request $request, EventPost $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        $rp = $request->user()->hasRole('partner') ? 'partner' : 'organizer';

        return redirect()->route($rp . '.posts.index')
            ->with('success', 'Post deleted.');
    }
}
