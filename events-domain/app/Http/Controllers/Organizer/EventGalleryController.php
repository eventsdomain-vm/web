<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventGalleryController extends Controller
{
    public function index(Event $event): View
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

        $images = $event->gallery()->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        return view('organizer.events.gallery.index', compact('event', 'images'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

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

        return redirect()->route('organizer.events.gallery.index', $event)
            ->with('success', 'Gallery images uploaded successfully!');
    }

    public function destroy(Event $event, EventGallery $gallery): RedirectResponse
    {
        abort_if($event->organizer_id !== auth()->id() || $gallery->event_id !== $event->id, 403);

        Storage::disk('public')->delete($gallery->image_url);
        $gallery->delete();

        return redirect()->route('organizer.events.gallery.index', $event)
            ->with('success', 'Image removed from gallery.');
    }
}
