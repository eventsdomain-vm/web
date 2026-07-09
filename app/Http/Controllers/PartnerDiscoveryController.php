<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PartnerDiscoveryController extends Controller
{
    public function index(Request $request): View
    {
        return view('partners.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'required|string|max:255',
            'partnership_type' => 'required|in:event_agency,venue,media,technology,other',
            'message' => 'required|string|max:2000',
        ]);

        $typeLabels = [
            'event_agency' => 'Event Agency',
            'venue' => 'Venue / Destination',
            'media' => 'Media Partner',
            'technology' => 'Event Technology',
            'other' => 'Other',
        ];

        $validated['partnership_type_label'] = $typeLabels[$validated['partnership_type']] ?? $validated['partnership_type'];

        \App\Models\PartnerEnquiry::create($validated);

        return redirect()->route('partners.index')
            ->with('success', 'Thank you for your enquiry! Our team will get back to you shortly.');
    }
}
