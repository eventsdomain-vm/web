<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\EventPost;
use App\Models\PostLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        // Social post stats
        $socialStats = [
            'total_posts' => EventPost::where('user_id', $user->id)->count(),
            'published_posts' => EventPost::where('user_id', $user->id)->where('status', 'published')->count(),
            'scheduled_posts' => EventPost::where('user_id', $user->id)->where('status', 'scheduled')->count(),
            'failed_posts' => EventPost::where('user_id', $user->id)->where('status', 'failed')->count(),
        ];

        // Reach & engagement per platform
        $platformStats = PostLog::whereHas('eventPost', fn ($q) => $q->where('user_id', $user->id))
            ->where('status', 'success')
            ->select(
                'platform',
                DB::raw('COUNT(*) as total_posts'),
                DB::raw('COALESCE(SUM(reach_impressions), 0) as total_impressions'),
                DB::raw('COALESCE(SUM(reach_reach), 0) as total_reach'),
                DB::raw('COALESCE(SUM(engagement_likes), 0) as total_likes'),
                DB::raw('COALESCE(SUM(engagement_comments), 0) as total_comments'),
                DB::raw('COALESCE(SUM(engagement_shares), 0) as total_shares'),
            )
            ->groupBy('platform')
            ->get();

        // Posts over time (last 30 days)
        $postsOverTime = EventPost::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published"),
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('analytics', compact('socialStats', 'platformStats', 'postsOverTime'));
    }
}
