<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\SponsorNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $notifications = SponsorNotification::where('user_id', $userId)
            ->latest()
            ->paginate(25);

        $unreadCount = SponsorNotification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();

        return view('sponsor.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(SponsorNotification $notification): RedirectResponse
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        if ($notification->action_url) {
            return redirect()->to($notification->action_url);
        }

        return redirect()->route('sponsor.notifications.index');
    }

    public function markAllAsRead(): RedirectResponse
    {
        SponsorNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->route('sponsor.notifications.index')
            ->with('success', 'All notifications marked as read.');
    }

    public function dismiss(SponsorNotification $notification): RedirectResponse
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->dismiss();

        return redirect()->route('sponsor.notifications.index');
    }
}
