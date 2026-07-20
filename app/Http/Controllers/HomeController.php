<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->withCount('events')
            ->orderBy('name')
            ->get();

        $featuredEvents = Event::query()
            ->where('approval_status', 'approved')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->whereNull('deleted_at')
            ->with('organizer', 'category')
            ->orderBy('start_date', 'asc')
            ->limit(4)
            ->get();

        return view('welcome', compact('featuredEvents', 'categories'));
    }
}
