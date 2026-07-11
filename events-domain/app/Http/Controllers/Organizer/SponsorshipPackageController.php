<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorshipPackage;
use App\Services\EventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SponsorshipPackageController extends Controller
{
    public function __construct(
        protected EventService $eventService,
    ) {}

    public function index(Event $event): View
    {
        $this->authorize('managePackages', $event);

        $packages = $event->packages()->with('benefitRecords')->get();

        return view('organizer.events.packages.index', compact('event', 'packages'));
    }

    public function create(Event $event): View
    {
        $this->authorize('managePackages', $event);

        return view('organizer.events.packages.create', compact('event'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('managePackages', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'slots_available' => 'required|integer|min:1',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string|max:500',
        ]);

        $this->eventService->createPackage($event, $validated);

        return redirect()->route('organizer.events.packages.index', $event)
            ->with('success', 'Sponsorship package created successfully!');
    }

    public function edit(Event $event, SponsorshipPackage $package): View
    {
        $this->authorize('managePackages', $event);

        abort_if($package->event_id !== $event->id, 404);

        return view('organizer.events.packages.edit', compact('event', 'package'));
    }

    public function update(Request $request, Event $event, SponsorshipPackage $package): RedirectResponse
    {
        $this->authorize('managePackages', $event);

        abort_if($package->event_id !== $event->id, 404);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'slots_available' => 'required|integer|min:1',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string|max:500',
        ]);

        $this->eventService->updatePackage($package, $validated);

        return redirect()->route('organizer.events.packages.index', $event)
            ->with('success', 'Sponsorship package updated successfully!');
    }

    public function destroy(Event $event, SponsorshipPackage $package): RedirectResponse
    {
        $this->authorize('managePackages', $event);

        abort_if($package->event_id !== $event->id, 404);

        $this->eventService->deletePackage($package);

        return redirect()->route('organizer.events.packages.index', $event)
            ->with('success', 'Sponsorship package deleted successfully!');
    }
}
