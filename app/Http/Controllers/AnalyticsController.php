<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPost;
use App\Models\PostLog;
use App\Services\GeoLocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $geoService = new GeoLocationService();

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

        // Event stats
        $eventStats = [
            'total_events' => Event::where('organizer_id', $user->id)->count(),
            'live_events' => Event::where('organizer_id', $user->id)->where('status', 'live')->count(),
            'draft_events' => Event::where('organizer_id', $user->id)->where('status', 'draft')->count(),
            'completed_events' => Event::where('organizer_id', $user->id)->where('status', 'completed')->count(),
        ];

        // Total views across all events
        $totalViews = Event::where('organizer_id', $user->id)->sum('views_count');

        // Top events by views
        $topEvents = Event::where('organizer_id', $user->id)
            ->orderByDesc('views_count')
            ->limit(5)
            ->get(['id', 'title', 'views_count', 'status', 'start_date']);

        // Visitor geo data
        $geoStats = $geoService->getVisitorGeoStats();

        // Device breakdown from sessions
        $deviceStats = DB::table('sessions')
            ->select(
                DB::raw("CASE
                    WHEN LOWER(user_agent) LIKE '%mobile%' OR LOWER(user_agent) LIKE '%android%' OR LOWER(user_agent) LIKE '%iphone%' THEN 'Mobile'
                    WHEN LOWER(user_agent) LIKE '%tablet%' OR LOWER(user_agent) LIKE '%ipad%' THEN 'Tablet'
                    ELSE 'Desktop'
                END as device"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('device')
            ->get();

        // Browser breakdown
        $browserStats = DB::table('sessions')
            ->select(
                DB::raw("CASE
                    WHEN LOWER(user_agent) LIKE '%chrome%' AND LOWER(user_agent) NOT LIKE '%edge%' THEN 'Chrome'
                    WHEN LOWER(user_agent) LIKE '%firefox%' THEN 'Firefox'
                    WHEN LOWER(user_agent) LIKE '%safari%' AND LOWER(user_agent) NOT LIKE '%chrome%' THEN 'Safari'
                    WHEN LOWER(user_agent) LIKE '%edge%' THEN 'Edge'
                    WHEN LOWER(user_agent) LIKE '%opera%' OR LOWER(user_agent) LIKE '%opr%' THEN 'Opera'
                    ELSE 'Other'
                END as browser"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('browser')
            ->orderByDesc('count')
            ->get();

        // Traffic over time (last 30 days from sessions)
        $trafficOverTime = DB::table('sessions')
            ->where('last_activity', '>=', now()->subDays(30)->timestamp)
            ->select(
                DB::raw('FROM_UNIXTIME(last_activity, "%Y-%m-%d") as date'),
                DB::raw('COUNT(*) as visitors')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Compute platform totals
        $platformTotals = [
            'impressions' => array_sum(array_column($platformStats->toArray(), 'total_impressions')),
            'reach' => array_sum(array_column($platformStats->toArray(), 'total_reach')),
            'likes' => array_sum(array_column($platformStats->toArray(), 'total_likes')),
            'comments' => array_sum(array_column($platformStats->toArray(), 'total_comments')),
            'shares' => array_sum(array_column($platformStats->toArray(), 'total_shares')),
            'posts' => array_sum(array_column($platformStats->toArray(), 'total_posts')),
        ];

        return view('analytics', [
            'socialStats' => $socialStats,
            'platformStats' => $platformStats->toArray(),
            'platformTotals' => $platformTotals,
            'postsOverTime' => $postsOverTime->toArray(),
            'eventStats' => $eventStats,
            'totalViews' => $totalViews,
            'topEvents' => $topEvents,
            'geoStats' => $geoStats,
            'deviceStats' => $deviceStats->toArray(),
            'browserStats' => $browserStats->toArray(),
            'trafficOverTime' => $trafficOverTime->toArray(),
        ]);
    }
}
