<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessageCenterController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $messages = SponsorMessage::where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->with(['sender', 'recipient'])
            ->latest()
            ->paginate(25);

        $unreadCount = SponsorMessage::where('recipient_id', $userId)
            ->whereNull('read_at')
            ->count();

        $conversations = SponsorMessage::select('sender_id', 'recipient_id', DB::raw('MAX(created_at) as last_message_at'))
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->orWhere('recipient_id', $userId);
            })
            ->groupBy('sender_id', 'recipient_id')
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($item) use ($userId) {
                $otherId = $item->sender_id === $userId ? $item->recipient_id : $item->sender_id;
                $other = User::find($otherId);
                $lastMsg = SponsorMessage::where(function ($q) use ($userId, $otherId) {
                    $q->where('sender_id', $userId)->where('recipient_id', $otherId);
                })->orWhere(function ($q) use ($userId, $otherId) {
                    $q->where('sender_id', $otherId)->where('recipient_id', $userId);
                })->latest()->first();

                $unread = SponsorMessage::where('sender_id', $otherId)
                    ->where('recipient_id', $userId)
                    ->whereNull('read_at')
                    ->count();

                return (object) [
                    'user' => $other,
                    'last_message' => $lastMsg,
                    'unread_count' => $unread,
                ];
            });

        return view('sponsor.messages.index', compact('messages', 'unreadCount', 'conversations'));
    }

    public function show(User $user): View
    {
        $userId = auth()->id();

        $messages = SponsorMessage::where(function ($q) use ($userId, $user) {
            $q->where('sender_id', $userId)->where('recipient_id', $user->id);
        })->orWhere(function ($q) use ($userId, $user) {
            $q->where('sender_id', $user->id)->where('recipient_id', $userId);
        })->with(['sender', 'recipient'])->orderBy('created_at')->get();

        SponsorMessage::where('sender_id', $user->id)
            ->where('recipient_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('sponsor.messages.show', compact('messages', 'user'));
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
        ]);

        $sponsor = Sponsor::where('user_id', auth()->id())->first();

        SponsorMessage::create([
            'sponsor_id' => $sponsor?->id,
            'sender_id' => auth()->id(),
            'recipient_id' => $user->id,
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
            'message_type' => 'direct',
        ]);

        return redirect()->route('sponsor.messages.show', $user)
            ->with('success', 'Message sent successfully.');
    }
}
