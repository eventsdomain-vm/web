<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipRequest;
use Illuminate\Http\Request;

class AdminSponsorshipController extends Controller
{
    public function index(Request $request)
    {
        $query = SponsorshipRequest::with(['event', 'sponsor', 'package']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%");
            });
        }

        $sponsorships = $query->latest()->paginate(20);

        return view('admin.sponsorships', compact('sponsorships'));
    }
}
