<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Sponsor;
use App\Models\SponsorshipRequest;
use App\Models\SponsorTeam;
use App\Models\SponsorTeamMember;
use App\Services\SponsorCollaborationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __construct(
        protected SponsorCollaborationService $collaborationService,
    ) {}

    protected function getSponsor(): ?Sponsor
    {
        return Sponsor::where('user_id', auth()->id())->first();
    }

    public function index(): View
    {
        $sponsor = $this->getSponsor();
        $sponsorId = $sponsor?->id;

        $teams = $sponsorId
            ? SponsorTeam::where('sponsor_id', $sponsorId)->with(['event', 'lead', 'members.user'])->get()
            : collect();

        $members = $sponsorId
            ? SponsorTeamMember::where('sponsor_id', $sponsorId)->with('user')->get()
            : collect();

        // Get events the sponsor is engaged with
        $events = $sponsorId
            ? Event::whereIn('id', SponsorshipRequest::where('sponsor_id', $sponsorId)->pluck('event_id')->unique())->get()
            : collect();

        return view('sponsor.teams.index', compact('teams', 'members', 'events'));
    }

    public function store(Request $request): RedirectResponse
    {
        $sponsor = $this->getSponsor();
        if (! $sponsor) {
            return back()->with('error', 'Sponsor profile not found. Complete your organization setup first.');
        }

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->collaborationService->createTeam([
            'sponsor_id' => $sponsor->id,
            'event_id' => $validated['event_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('sponsor.teams.index')
            ->with('success', 'Team created for project.');
    }

    public function addMember(Request $request, SponsorTeam $team): RedirectResponse
    {
        $sponsor = $this->getSponsor();
        if (! $sponsor || $team->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'designation' => 'required|string|max:255',
            'role' => 'required|in:viewer,editor,approver,finance',
        ]);

        // Find or create user
        $user = \App\Models\User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'password' => bcrypt(str()->random(16)),
                'email_verified_at' => now(),
            ]
        );

        // Add team member with designation
        SponsorTeamMember::firstOrCreate(
            [
                'team_id' => $team->id,
                'user_id' => $user->id,
            ],
            [
                'sponsor_id' => $sponsor->id,
                'role' => $validated['role'],
                'designation' => $validated['designation'],
            ]
        );

        return redirect()->route('sponsor.teams.index')
            ->with('success', 'Member added to team.');
    }

    public function removeMember(SponsorTeam $team, SponsorTeamMember $member): RedirectResponse
    {
        $sponsor = $this->getSponsor();
        if (! $sponsor || $team->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        $this->collaborationService->removeTeamMember($team, $member->user_id);

        return redirect()->route('sponsor.teams.index')
            ->with('success', 'Member removed.');
    }
}
