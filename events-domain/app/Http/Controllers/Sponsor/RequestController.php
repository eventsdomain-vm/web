<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipRequest;

class RequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->sponsorshipRequests()
            ->with('event', 'package')
            ->latest()
            ->paginate(10);

        return view('sponsor.requests.index', compact('requests'));
    }

    public function show(SponsorshipRequest $request)
    {
        if ($request->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $request->load('event', 'package.benefitRecords', 'contract');

        return view('sponsor.requests.show', compact('request'));
    }
}
