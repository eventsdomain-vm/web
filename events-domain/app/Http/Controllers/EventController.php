<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::published()->with('organizer', 'category');

        $sort = $request->sort ?? 'upcoming';

        switch ($sort) {
            case 'past':
                $query->where('start_date', '<', now())->orderByDesc('start_date');
                break;
            case 'upcoming':
                $query->where('start_date', '>=', now())->orderBy('start_date');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            default:
                $query->where('start_date', '>=', now())->orderBy('start_date');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('type')) {
            $query->where('event_type', $request->type);
        }

        if ($request->filled('sponsorship_type')) {
            $query->where('sponsorship_type', $request->sponsorship_type);
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->filled('budget_range')) {
            $range = $request->budget_range;
            if (str_ends_with($range, '+')) {
                $min = (int) str_replace('+', '', $range);
                $query->where('budget_max', '>=', $min);
            } elseif (str_contains($range, '-')) {
                [$min, $max] = explode('-', $range);
                $query->where(function ($q) use ($min, $max) {
                    $q->whereBetween('budget_min', [(int) $min, (int) $max])
                        ->orWhereBetween('budget_max', [(int) $min, (int) $max])
                        ->orWhere(function ($q2) use ($min, $max) {
                            $q2->where('budget_min', '<=', (int) $min)
                                ->where('budget_max', '>=', (int) $max);
                        });
                });
            }
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $events = $query->paginate(12)->withQueryString();
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
        $cities = Event::published()->whereNotNull('city')->distinct()->pluck('city')->sort();
        $countries = Event::published()->whereNotNull('country')->distinct()->pluck('country')->sort();

        return view('events.index', compact('events', 'categories', 'cities', 'countries', 'sort'));
    }

    public function show(string $slug)
    {
        $event = Event::published()
            ->where('slug', $slug)
            ->with('organizer', 'category', 'packages.benefitRecords', 'gallery')
            ->firstOrFail();

        $event->incrementViews();

        return view('events.show', compact('event'));
    }
}
