<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SponsorAnnouncement;
use App\Models\SponsorAnnouncementReceipt;

class SponsorCommunicationService
{
    public function createAnnouncement(array $data): SponsorAnnouncement
    {
        return SponsorAnnouncement::create($data);
    }

    public function publishAnnouncement(SponsorAnnouncement $announcement): void
    {
        $announcement->publish();
    }

    public function markAsRead(SponsorAnnouncement $announcement, int $userId): void
    {
        SponsorAnnouncementReceipt::firstOrCreate([
            'announcement_id' => $announcement->id,
            'user_id' => $userId,
            'read_at' => now(),
        ]);
    }

    public function getUnreadAnnouncements(int $sponsorId, int $userId): array
    {
        $announcements = SponsorAnnouncement::where('sponsor_id', $sponsorId)
            ->where('status', 'published')
            ->whereDoesntHave('receipts', fn ($q) => $q->where('user_id', $userId))
            ->orderByDesc('published_at')
            ->get();

        return [
            'total_unread' => $announcements->count(),
            'announcements' => $announcements,
        ];
    }

    public function getAnnouncementStats(int $sponsorId): array
    {
        $total = SponsorAnnouncement::where('sponsor_id', $sponsorId)->count();
        $published = SponsorAnnouncement::where('sponsor_id', $sponsorId)->where('status', 'published')->count();
        $totalReceipts = SponsorAnnouncementReceipt::whereHas(
            'announcement',
            fn ($q) => $q->where('sponsor_id', $sponsorId),
        )->count();

        return [
            'total' => $total,
            'published' => $published,
            'total_reads' => $totalReceipts,
            'avg_read_rate' => $total > 0 ? round($totalReceipts / ($published ?: 1)) : 0,
        ];
    }
}
