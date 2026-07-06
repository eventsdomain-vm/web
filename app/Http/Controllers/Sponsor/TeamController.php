<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
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
            ? SponsorTeam::where('sponsor_id', $sponsorId)->with(['lead', 'members.user'])->get()
            : collect();

        $members = SponsorTeamMember::where('sponsor_id', auth()->id())
            ->with('user')
            ->get();

        return view('sponsor.teams.index', compact('teams', 'members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $sponsor = $this->getSponsor();
        if (! $sponsor) {
            return back()->with('error', 'Sponsor profile not found. Complete your organization setup first.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->collaborationService->createTeam([
            'sponsor_id' => $sponsor->id,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('sponsor.teams.index')
            ->with('success', 'Team created.');
    }

    public function addMember(Request $request, SponsorTeam $team): RedirectResponse
    {
        $sponsor = $this->getSponsor();
        if (! $sponsor || $team->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,editor,viewer,approver,finance',
        ]);

        $this->collaborationService->addTeamMember($team, $validated['user_id'], $validated['role']);

        return redirect()->route('sponsor.teams.index')
            ->with('success', 'Member added.');
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
