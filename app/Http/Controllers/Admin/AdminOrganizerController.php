<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizerProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrganizerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('organizer')->with('profile');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $organizers = $query->latest()->paginate(20);

        return view('admin.organizers.index', compact('organizers'));
    }

    public function show(User $organizer)
    {
        $organizer->load('profile', 'roles');
        $profile = OrganizerProfile::where('user_id', $organizer->id)->first();
        $events = $organizer->organizedEvents()->with('category')->latest()->paginate(10);
        $contracts = \App\Models\SponsorshipContract::whereIn(
            'event_id',
            $organizer->organizedEvents()->pluck('id')
        )->with(['sponsor', 'event'])->latest()->paginate(10);

        return view('admin.organizers.show', compact('organizer', 'profile', 'events', 'contracts'));
    }

    public function updateProfile(Request $request, User $organizer)
    {
        $validated = $request->validate([
            'organization_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:500',
            'bio' => 'nullable|string|max:2000',
        ]);

        OrganizerProfile::updateOrCreate(['user_id' => $organizer->id], $validated);

        return redirect()->route('admin.organizers.show', $organizer)
            ->with('success', 'Organizer profile updated.');
    }
}
