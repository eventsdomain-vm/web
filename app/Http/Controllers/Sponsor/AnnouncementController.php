<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorAnnouncement;
use App\Services\SponsorCommunicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct(
        protected SponsorCommunicationService $communicationService,
    ) {}

    protected function getSponsorId(): ?int
    {
        return Sponsor::where('user_id', auth()->id())->value('id');
    }

    public function index(): View
    {
        $sponsorId = $this->getSponsorId();

        $announcements = SponsorAnnouncement::where('sponsor_id', $sponsorId)
            ->with('creator')
            ->latest()
            ->paginate(20);

        $stats = $sponsorId
            ? $this->communicationService->getAnnouncementStats($sponsorId)
            : ['total' => 0, 'published' => 0, 'total_reads' => 0, 'avg_read_rate' => 0];

        return view('sponsor.announcements.index', compact('announcements', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId) {
            return back()->with('error', 'Sponsor profile not found.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:general,campaign_update,contract,team,urgent',
            'audience_type' => 'required|in:internal,cross_org,public',
        ]);

        $this->communicationService->createAnnouncement([
            'sponsor_id' => $sponsorId,
            'created_by' => auth()->id(),
            ...$validated,
            'status' => 'draft',
        ]);

        return redirect()->route('sponsor.announcements.index')
            ->with('success', 'Announcement created.');
    }

    public function publish(SponsorAnnouncement $announcement): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId || $announcement->sponsor_id !== $sponsorId) {
            abort(403);
        }

        $this->communicationService->publishAnnouncement($announcement);

        return redirect()->route('sponsor.announcements.index')
            ->with('success', 'Announcement published.');
    }
}
