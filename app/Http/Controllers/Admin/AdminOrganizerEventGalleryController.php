<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminOrganizerEventGalleryController extends Controller
{
    public function index(Event $event)
    {
        $images = $event->gallery()->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        return view('admin.organizers.event-gallery', compact('event', 'images'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,webp|max:5120',
        ]);

        $sortOrder = $event->gallery()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $path = $file->store('events/gallery', 'public');
            EventGallery::create([
                'event_id' => $event->id,
                'image_url' => $path,
                'sort_order' => ++$sortOrder,
            ]);
        }

        return redirect()->route('admin.events.gallery', $event)
            ->with('success', 'Gallery images uploaded.');
    }

    public function destroy(Event $event, EventGallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_url);
        $gallery->delete();

        return redirect()->route('admin.events.gallery', $event)
            ->with('success', 'Image removed from gallery.');
    }
}
