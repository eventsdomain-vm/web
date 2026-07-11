<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventPost;
use App\Models\SocialAccount;
use Illuminate\Http\Request;

class AdminOrganizerSocialController extends Controller
{
    public function accounts(Request $request)
    {
        $query = SocialAccount::with('user');

        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $accounts = $query->latest()->paginate(20);

        return view('admin.organizers.social-accounts', compact('accounts'));
    }

    public function posts(Request $request)
    {
        $query = EventPost::with(['user', 'event', 'logs']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%");
            });
        }

        $posts = $query->latest()->paginate(20);

        return view('admin.organizers.social-posts', compact('posts'));
    }

    public function showPost(EventPost $post)
    {
        $post->load(['user', 'event', 'logs']);

        return view('admin.organizers.social-post-show', compact('post'));
    }
}
