<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\DTOs\EventCreateData;
use App\DTOs\EventUpdateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveDraftRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Event;
use App\Models\ParticipantType;
use App\Services\EventService;
use App\Traits\MediaUploadable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    use MediaUploadable;

    public function __construct(
        protected EventService $eventService,
    ) {}

    public function saveDraft(SaveDraftRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        $dto = EventCreateData::fromRequest($validated, $user->id);

        $datesData = $request->input('dates');
        $venuesData = $request->input('venues');
        $packagesData = $request->input('packages');

        $event = $this->eventService->createEvent($dto, $packagesData, $datesData, $venuesData, isDraft: true);

        $this->uploadMediaFiles($event, $request);

        return response()->json([
            'success' => true,
            'message' => 'Draft saved successfully',
            'event_id' => $event->id,
        ]);
    }

    public function loadDraft()
    {
        $user = auth()->user();
        $draft = Event::where('organizer_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (! $draft) {
            return response()->json([
                'success' => false,
                'message' => 'No draft found',
            ], 404);
        }

        $draft->load(['packages', 'dates', 'venues', 'participants']);

        return response()->json([
            'success' => true,
            'data' => $draft,
        ]);
    }

    public function discardDraft($id)
    {
        $user = auth()->user();
        $event = Event::where('id', $id)
            ->where('organizer_id', $user->id)
            ->where('status', 'draft')
            ->first();

        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Draft not found',
            ], 404);
        }

        $this->eventService->deleteEvent($event);

        return response()->json([
            'success' => true,
            'message' => 'Draft discarded',
        ]);
    }

    public function dashboard(): View
    {
        $user = auth()->user();
        $stats = $this->eventService->getOrganizerStats($user->id);
        $stats['unread_enquiries'] = 0;

        $recentEvents = Event::where('organizer_id', $user->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('organizer.dashboard', ['stats' => $stats, 'recentEvents' => $recentEvents]);
    }

    public function index(Request $request): View
    {
        $user = auth()->user();
        $events = $this->eventService->paginatedForOrganizer(
            $user->id,
            15,
            $request->input('status'),
            $request->input('search'),
        );

        $statusFilter = $request->input('status', 'live');

        return view('organizer.events.index', ['events' => $events, 'statusFilter' => $statusFilter]);
    }

    public function create(): View
    {
        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
        $participantTypes = ParticipantType::orderBy('sort_order')->get();
        $amenities = Amenity::orderBy('sort_order')->get();

        return view('organizer.events.create', [
            'categories' => $categories,
            'participantTypes' => $participantTypes,
            'amenities' => $amenities,
        ]);
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validated();

        $dto = EventCreateData::fromRequest($validated, $user->id);

        $packageData = $request->input('packages');
        $datesData = $request->input('dates');
        $venuesData = $request->input('venues');
        $participantsData = $request->input('participants');
        $teamData = $request->input('team');

        $event = $this->eventService->createEvent($dto, $packageData, $datesData, $venuesData, $participantsData, $teamData);

        $this->uploadMediaFiles($event, $request);

        return redirect()->route('organizer.events.show', $event->id)
            ->with('success', 'Event submitted successfully and is pending approval.');
    }

    public function show(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load(['category', 'packages.benefitRecords', 'schedule', 'gallery', 'team', 'sponsorshipRequests.sponsor', 'sponsorshipRequests.package', 'partnerBids.partner', 'partnerBids.service']);

        return view('organizer.events.show', ['event' => $event]);
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();

        return view('organizer.events.edit', ['event' => $event, 'categories' => $categories]);
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $validated = $request->validated();
        $dto = EventUpdateData::fromRequest($validated);

        $event = $this->eventService->updateEvent($event, $dto);

        $this->uploadMediaFiles($event, $request);

        return redirect()->route('organizer.events.show', $event->id)
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $this->eventService->deleteEvent($event);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
