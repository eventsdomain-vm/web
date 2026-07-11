<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorshipRequest;
use Illuminate\Http\RedirectResponse;

class SponsorController extends Controller
{
    public function acceptRequest(Event $event, SponsorshipRequest $request): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($request->event_id !== $event->id, 404);

        $request->accept();

        return redirect()->back()
            ->with('success', 'Sponsorship request accepted successfully.');
    }

    public function rejectRequest(Event $event, SponsorshipRequest $request): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($request->event_id !== $event->id, 404);

        $request->reject();

        return redirect()->back()
            ->with('success', 'Sponsorship request rejected.');
    }
}
