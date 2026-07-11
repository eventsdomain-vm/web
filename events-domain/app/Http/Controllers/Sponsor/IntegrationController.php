<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorIntegration;
use App\Services\SponsorAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IntegrationController extends Controller
{
    public function __construct(
        protected SponsorAdminService $adminService,
    ) {}

    protected function getSponsorId(): ?int
    {
        return Sponsor::where('user_id', auth()->id())->value('id');
    }

    public function index(): View
    {
        $sponsorId = $this->getSponsorId();

        $integrations = $sponsorId
            ? SponsorIntegration::where('sponsor_id', $sponsorId)->with('logs')->get()
            : collect();

        return view('sponsor.integrations.index', compact('integrations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId) {
            return back()->with('error', 'Sponsor profile not found.');
        }

        $validated = $request->validate([
            'provider' => 'required|string|max:100',
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:crm,analytics,communication,automation,payment',
        ]);

        $this->adminService->connectIntegration([
            'sponsor_id' => $sponsorId,
            ...$validated,
        ]);

        return redirect()->route('sponsor.integrations.index')
            ->with('success', 'Integration added.');
    }

    public function disconnect(SponsorIntegration $integration): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId || $integration->sponsor_id !== $sponsorId) {
            abort(403);
        }

        $this->adminService->disconnectIntegration($integration);

        return redirect()->route('sponsor.integrations.index')
            ->with('success', 'Integration disconnected.');
    }
}
