<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\AudienceType;
use App\Models\Category;
use App\Models\Event;
use App\Models\EventAdSpace;
use App\Models\EventAudience;
use App\Models\EventDraft;
use App\Models\EventFnbOption;
use App\Models\EventGallery;
use App\Models\EventSponsorshipLevel;
use App\Models\EventStall;
use App\Models\Industry;
use App\Models\Participant;
use App\Models\ParticipantType;
use App\Models\EventParticipant;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmitEventController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
        $plans = Plan::orderBy('price')->get();
        $audienceTypes = AudienceType::orderBy('label')->get();
        $ageGroups = AgeGroup::orderBy('sort_order')->get();
        $industries = Industry::orderBy('label')->get();

        $draft = EventDraft::where('user_id', Auth::id())->first();

        return view('organizer.events.create', compact(
            'categories', 'plans', 'audienceTypes', 'ageGroups', 'industries', 'draft'
        ));
    }

    public function saveDraft(Request $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->all();
        unset($data['_token']);

        $draft = EventDraft::updateOrCreate(
            ['user_id' => $user->id],
            [
                'current_step' => $data['current_step'] ?? 1,
                'data' => $data,
            ]
        );

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
        ]);
    }

    public function loadDraft(): JsonResponse
    {
        $user = Auth::user();
        $draft = EventDraft::where('user_id', $user->id)->first();

        if (!$draft) {
            return response()->json(['success' => false], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $draft->data,
            'current_step' => $draft->current_step,
        ]);
    }

    public function clearDraft(): JsonResponse
    {
        $user = Auth::user();
        EventDraft::where('user_id', $user->id)->delete();

        return response()->json(['success' => true]);
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $user = Auth::user();
        $path = $request->file('image')->store('draft-uploads/' . $user->id, 'public');

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    public function submit(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        unset($data['_token']);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'start_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date|gte:start_date',
            'end_time' => 'nullable|date_format:H:i',
            'venue_name' => 'required|max:255',
            'venue_address' => 'nullable|max:500',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'contact_no' => 'nullable|string|max:30',
            'website_url' => 'nullable|url|max:500',
            'cover_image' => 'nullable|string',
            'logo' => 'nullable|string',
            'expected_audience_size' => 'nullable|integer|min:1',
            'sponsorship_budget_range' => 'nullable|string',
            'sponsorship_type' => 'required|in:cash,barter,paid_barter',
            'sponsorship_levels' => 'nullable|array',
            'sponsorship_levels.*' => 'string|in:title,co_sponsor,associate,powered_by,media_partner,other',
            'sponsorship_details' => 'nullable|array',
            'sponsorship_benefits' => 'nullable|array',
            'sponsorship_benefits.*' => 'string',
            'stalls' => 'nullable|array',
            'stalls.*.name' => 'nullable|string|max:255',
            'stalls.*.description' => 'nullable|string|max:1000',
            'stalls.*.price' => 'nullable|numeric|min:0',
            'fnb_options' => 'nullable|array',
            'fnb_options.*.name' => 'nullable|string|max:255',
            'fnb_options.*.description' => 'nullable|string|max:1000',
            'fnb_options.*.price' => 'nullable|numeric|min:0',
            'ad_spaces' => 'nullable|array',
            'ad_spaces.*.name' => 'nullable|string|max:255',
            'ad_spaces.*.description' => 'nullable|string|max:1000',
            'ad_spaces.*.price' => 'nullable|numeric|min:0',
            'audience_type_ids' => 'nullable|array',
            'audience_type_ids.*' => 'integer|exists:audience_types,id',
            'age_group_ids' => 'nullable|array',
            'age_group_ids.*' => 'integer|exists:age_groups,id',
            'gender_composition' => 'nullable|in:mostly_male,mostly_female,balanced',
            'income_level' => 'nullable|string',
            'geographic_reach' => 'nullable|in:local,regional,national,international',
            'target_market_summary' => 'nullable|string|max:2000',
            'industry_ids' => 'nullable|array',
            'industry_ids.*' => 'integer|exists:industries,id',
            'youtube_url' => 'nullable|url',
            'plan' => 'required|in:basic,featured,homepage',
            'participants' => 'nullable|array',
            'participants.*.name' => 'required_with:participants|string|max:255',
            'participants.*.type' => 'required_with:participants|string|max:80',
            'participants.*.bio' => 'nullable|string|max:2000',
            'participants.*.organization' => 'nullable|string|max:255',
            'participants.*.designation' => 'nullable|string|max:255',
            'participants.*.photo_path' => 'nullable|string',
            'schedule' => 'nullable|array',
            'schedule.*.date' => 'required_with:schedule|date',
            'schedule.*.participant_idx' => 'required_with:schedule|integer|min:0',
            'schedule.*.start_time' => 'required_with:schedule|date_format:H:i',
            'schedule.*.end_time' => 'required_with:schedule|date_format:H:i',
            'image_paths' => 'nullable|array',
            'image_paths.*' => 'string',
        ]);

        DB::transaction(function () use ($validated, $data, $user, $request) {
            $sponsorshipTypeMap = [
                'cash' => 'paid',
                'barter' => 'barter',
                'paid_barter' => 'hybrid',
            ];

            $event = Event::create([
                'organizer_id' => $user->id,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'subcategory_id' => $validated['subcategory_id'] ?? null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'] ?? null,
                'venue' => $validated['venue_name'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? 'India',
                'contact_no' => $validated['contact_no'] ?? null,
                'website_url' => $validated['website_url'] ?? null,
                'cover_image' => $validated['cover_image'] ?? null,
                'logo' => $validated['logo'] ?? null,
                'expected_audience' => $validated['expected_audience_size'] ?? null,
                'sponsorship_type' => $sponsorshipTypeMap[$validated['sponsorship_type']] ?? $validated['sponsorship_type'],
                'budget_min' => null,
                'budget_max' => null,
                'video_url' => $validated['youtube_url'] ?? null,
                'plan' => $validated['plan'],
                'status' => 'pending',
                'approval_status' => 'pending',
            ]);

            if (!empty($validated['sponsorship_levels'])) {
                $details = $request->input('sponsorship_details', []);
                $benefits = $request->input('sponsorship_benefits', []);

                $levelNames = [
                    'title' => 'Title Sponsor',
                    'co_sponsor' => 'Co-Sponsor',
                    'associate' => 'Associate Sponsor',
                    'powered_by' => 'Powered By Sponsor',
                    'media_partner' => 'Media Partner',
                    'other' => 'Other Sponsor',
                ];

                $levelDescriptions = [
                    'title' => 'Primary sponsor with maximum visibility',
                    'co_sponsor' => 'Secondary sponsor with significant branding',
                    'associate' => 'Supporting sponsor with moderate visibility',
                    'powered_by' => 'Technical/infrastructure sponsor',
                    'media_partner' => 'Media coverage sponsor',
                    'other' => 'Custom sponsorship level',
                ];

                $priceMap = [
                    'Under 1 Lakh' => 50000,
                    '1-5 Lakhs' => 250000,
                    '5-10 Lakhs' => 750000,
                    '10-25 Lakhs' => 1750000,
                    '25-50 Lakhs' => 3750000,
                    '50 Lakhs+' => 5000000,
                ];

                foreach ($validated['sponsorship_levels'] as $level) {
                    $dbLevel = $level === 'other' ? 'associate' : $level;

                    EventSponsorshipLevel::create([
                        'event_id' => $event->id,
                        'level' => $dbLevel,
                    ]);

                    $pkgDetails = $details[$level] ?? [];
                    $slots = $level === 'title' ? 1 : (int)($pkgDetails['slots'] ?? 1);
                    $budget = $pkgDetails['budget_per_slot'] ?? 'Under 1 Lakh';
                    $price = $priceMap[$budget] ?? 0;
                    $titleName = ($level === 'other' && !empty($pkgDetails['name'])) ? $pkgDetails['name'] : ($levelNames[$level] ?? ucfirst($level));
                    $description = $levelDescriptions[$level] ?? '';

                    $package = $event->packages()->create([
                        'title' => $titleName,
                        'level' => $dbLevel,
                        'description' => $description,
                        'price' => $price,
                        'currency' => 'INR',
                        'budget_range_label' => $budget,
                        'slots_available' => $slots,
                        'slots_filled' => 0,
                        'is_active' => true,
                    ]);

                    if (!empty($benefits)) {
                        foreach ($benefits as $bText) {
                            $package->benefitRecords()->create([
                                'benefit_text' => $bText
                            ]);
                        }
                    }
                }
            }

            if (!empty($validated['stalls'])) {
                foreach ($validated['stalls'] as $stall) {
                    if (!empty($stall['name'])) {
                        EventStall::create([
                            'event_id' => $event->id,
                            'name' => $stall['name'],
                            'description' => $stall['description'] ?? null,
                            'price' => $stall['price'] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($validated['fnb_options'])) {
                foreach ($validated['fnb_options'] as $fnb) {
                    if (!empty($fnb['name'])) {
                        EventFnbOption::create([
                            'event_id' => $event->id,
                            'name' => $fnb['name'],
                            'description' => $fnb['description'] ?? null,
                            'price' => $fnb['price'] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($validated['ad_spaces'])) {
                foreach ($validated['ad_spaces'] as $ad) {
                    if (!empty($ad['name'])) {
                        EventAdSpace::create([
                            'event_id' => $event->id,
                            'name' => $ad['name'],
                            'description' => $ad['description'] ?? null,
                            'price' => $ad['price'] ?? null,
                        ]);
                    }
                }
            }

            $hasAudience = !empty($validated['audience_type_ids'])
                || !empty($validated['age_group_ids'])
                || !empty($validated['gender_composition'])
                || !empty($validated['income_level'])
                || !empty($validated['geographic_reach'])
                || !empty($validated['target_market_summary'])
                || !empty($validated['industry_ids']);

            if ($hasAudience) {
                EventAudience::create([
                    'event_id' => $event->id,
                    'audience_types' => $validated['audience_type_ids'] ?? null,
                    'age_groups' => $validated['age_group_ids'] ?? null,
                    'gender_composition' => $validated['gender_composition'] ?? null,
                    'income_level' => $validated['income_level'] ?? null,
                    'geographic_reach' => $validated['geographic_reach'] ?? null,
                    'target_market_summary' => $validated['target_market_summary'] ?? null,
                    'industry_alignment' => $validated['industry_ids'] ?? null,
                ]);
            }

            // Process participants (Artists / Speakers / Celebrities)
            if (!empty($validated['participants'])) {
                $typeSlugMap = [
                    'speaker' => 'speaker',
                    'artist' => 'artist',
                    'celebrity' => 'celebrity',
                    'dj' => 'dj',
                    'panelist' => 'panelist',
                    'judge' => 'judge',
                    'mentor' => 'mentor',
                    'moderator' => 'moderator',
                ];

                foreach ($validated['participants'] as $idx => $p) {
                    if (empty($p['name'])) continue;

                    $participantTypeSlug = $typeSlugMap[$p['type']] ?? 'speaker';
                    $participantType = ParticipantType::where('slug', $participantTypeSlug)->first();

                    $slug = \Illuminate\Support\Str::slug($p['name']);
                    $existing = Participant::where('slug', $slug)->first();
                    if ($existing) {
                        $participant = $existing;
                    } else {
                        $participant = Participant::create([
                            'name' => $p['name'],
                            'slug' => $slug . '-' . uniqid(),
                            'type' => $p['type'] ?? null,
                            'bio' => $p['bio'] ?? null,
                            'organization' => $p['organization'] ?? null,
                            'designation' => $p['designation'] ?? null,
                        ]);
                    }

                    // Move photo if uploaded
                    if (!empty($p['photo_path']) && Storage::disk('public')->exists($p['photo_path'])) {
                        $filename = basename($p['photo_path']);
                        $newPath = 'events/' . $event->id . '/participants/' . $filename;
                        Storage::disk('public')->move($p['photo_path'], $newPath);
                        $participant->update(['image' => $newPath]);
                    }

                    EventParticipant::create([
                        'event_id' => $event->id,
                        'participant_id' => $participant->id,
                        'participant_type_id' => $participantType?->id,
                        'role_label' => $p['designation'] ?? null,
                        'sort_order' => $idx,
                    ]);
                }

                // Process schedule assignments (date → artist → time)
                $schedule = $request->input('schedule', []);
                foreach ($schedule as $sch) {
                    $pIdx = $sch['participant_idx'] ?? null;
                    if ($pIdx === null || !isset($validated['participants'][$pIdx])) continue;

                    $p = $validated['participants'][$pIdx];
                    $participantTypeSlug = $p['type'] ?? 'artist';
                    $participantType = ParticipantType::where('slug', $participantTypeSlug)->first();
                    $slug = \Illuminate\Support\Str::slug($p['name']);
                    $existing = Participant::where('slug', $slug)->first();
                    if (!$existing) continue;

                    $eventParticipant = EventParticipant::where('event_id', $event->id)
                        ->where('participant_id', $existing->id)
                        ->first();

                    if ($eventParticipant) {
                        $eventParticipant->update([
                            'event_date_id' => null,
                            'performance_start' => $sch['date'] . ' ' . $sch['start_time'] . ':00',
                            'performance_end' => $sch['date'] . ' ' . $sch['end_time'] . ':00',
                        ]);
                    }
                }

                // Auto-set has_celebrity flag if any celebrity participant exists
                $hasCelebrity = collect($validated['participants'])->contains('type', 'celebrity');
                if ($hasCelebrity) {
                    $event->update(['has_celebrity' => true]);
                }
            }

            // Move cover_image to event folder
            if (!empty($validated['cover_image']) && Storage::disk('public')->exists($validated['cover_image'])) {
                $filename = basename($validated['cover_image']);
                $newPath = 'events/' . $event->id . '/cover/' . $filename;
                Storage::disk('public')->makeDirectory('events/' . $event->id . '/cover');
                Storage::disk('public')->move($validated['cover_image'], $newPath);
                $event->update(['cover_image' => $newPath]);
            }

            // Move logo to event folder
            if (!empty($validated['logo']) && Storage::disk('public')->exists($validated['logo'])) {
                $filename = basename($validated['logo']);
                $newPath = 'events/' . $event->id . '/logo/' . $filename;
                Storage::disk('public')->makeDirectory('events/' . $event->id . '/logo');
                Storage::disk('public')->move($validated['logo'], $newPath);
                $event->update(['logo' => $newPath]);
            }

            // Process pre-uploaded temporary image paths (gallery)
            if (!empty($validated['image_paths'])) {
                foreach ($validated['image_paths'] as $i => $tempPath) {
                    if (Storage::disk('public')->exists($tempPath)) {
                        $filename = basename($tempPath);
                        $newPath = 'events/' . $event->id . '/gallery/' . $filename;
                        Storage::disk('public')->makeDirectory('events/' . $event->id . '/gallery');
                        Storage::disk('public')->move($tempPath, $newPath);
                        EventGallery::create([
                            'event_id' => $event->id,
                            'image_url' => $newPath,
                            'sort_order' => $i,
                        ]);
                    }
                }
            }

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $i => $image) {
                    $path = $image->store('events/' . $event->id . '/gallery', 'public');
                    EventGallery::create([
                        'event_id' => $event->id,
                        'image_url' => $path,
                        'sort_order' => $i,
                    ]);
                }
            }

            EventDraft::where('user_id', $user->id)->delete();
        });

        if ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'redirect' => route('organizer.events.index'),
                'message' => 'Event submitted successfully! It will be reviewed within 24-48 hours.',
            ]);
        }

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event submitted successfully! It will be reviewed within 24-48 hours.');
    }
}
