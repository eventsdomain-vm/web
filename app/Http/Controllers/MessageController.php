<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $conversations = Conversation::whereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['participants.user', 'messages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->withCount('messages')
            ->latest()
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is a participant
        if (! $conversation->participants->contains('user_id', $user->id)) {
            abort(403);
        }

        // Mark as read
        $conversation->participants()
            ->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);

        $conversation->load(['participants.user', 'messages.sender']);

        // Get the other participant
        $otherParticipant = $conversation->participants
            ->where('user_id', '!=', $user->id)
            ->first()
            ->user;

        return view('messages.show', compact('conversation', 'otherParticipant'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is a participant
        if (! $conversation->participants->contains('user_id', $user->id)) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $validated['content'],
        ]);

        // Update conversation timestamp
        $conversation->update(['updated_at' => now()]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender' => $user->name,
                    'avatar' => $user->avatar_url,
                    'created_at' => $message->created_at->diffForHumans(),
                ],
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    public function create(User $user)
    {
        $currentUser = Auth::user();

        // Check if conversation already exists
        $conversation = Conversation::whereHas('participants', function ($query) use ($currentUser) {
            $query->where('user_id', $currentUser->id);
        })
            ->whereHas('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->first();

        if ($conversation) {
            return redirect()->route('messages.show', $conversation);
        }

        // Create new conversation
        $conversation = Conversation::create([
            'type' => 'direct',
            'subject' => "Chat between {$currentUser->name} and {$user->name}",
        ]);

        // Add participants
        $conversation->participants()->create([
            'user_id' => $currentUser->id,
        ]);

        $conversation->participants()->create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('messages.show', $conversation);
    }
}
