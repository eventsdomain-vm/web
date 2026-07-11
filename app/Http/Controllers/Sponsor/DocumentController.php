<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorDocument;
use App\Services\SponsorAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
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

        $documents = SponsorDocument::where('sponsor_id', $sponsorId)
            ->with('uploader')
            ->latest()
            ->paginate(20);

        return view('sponsor.documents.index', compact('documents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId) {
            return back()->with('error', 'Sponsor profile not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'file_path' => 'required|string|max:500',
            'campaign_id' => 'nullable|exists:sponsor_campaigns,id',
            'contract_id' => 'nullable|exists:sponsorship_contracts,id',
            'description' => 'nullable|string',
        ]);

        $this->adminService->uploadDocument([
            'sponsor_id' => $sponsorId,
            'uploaded_by' => auth()->id(),
            ...$validated,
        ]);

        return redirect()->route('sponsor.documents.index')
            ->with('success', 'Document uploaded.');
    }

    public function finalize(SponsorDocument $document): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId || $document->sponsor_id !== $sponsorId) {
            abort(403);
        }

        $this->adminService->finalizeDocument($document);

        return redirect()->route('sponsor.documents.index')
            ->with('success', 'Document finalized.');
    }
}
