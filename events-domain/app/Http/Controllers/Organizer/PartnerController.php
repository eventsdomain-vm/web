<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PartnerBid;
use Illuminate\Http\RedirectResponse;

class PartnerController extends Controller
{
    public function acceptBid(Event $event, PartnerBid $bid): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($bid->event_id !== $event->id, 404);

        $bid->update(['status' => 'accepted']);

        return redirect()->back()
            ->with('success', 'Partner bid accepted successfully.');
    }

    public function rejectBid(Event $event, PartnerBid $bid): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($bid->event_id !== $event->id, 404);

        $bid->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', 'Partner bid rejected.');
    }
}
