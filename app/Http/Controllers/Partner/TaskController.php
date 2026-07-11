<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerActivityLog;
use App\Models\PartnerTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerTask::with(['sponsor', 'assignedTo'])
            ->where('partner_id', Auth::id());

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->orderByDesc('created_at')->paginate(20);

        return view('partner.tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('partner.tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sponsor_id' => 'nullable|exists:sponsors,id',
            'deal_id' => 'nullable|exists:partner_deals,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $validated['partner_id'] = Auth::id();
        $validated['assigned_to'] ??= Auth::id();

        $task = PartnerTask::create($validated);

        PartnerActivityLog::create([
            'partner_id' => Auth::id(),
            'causer_id' => Auth::id(),
            'subject_type' => PartnerTask::class,
            'subject_id' => $task->id,
            'event' => 'created',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('partner.tasks.index')->with('success', 'Task created.');
    }

    public function show(int $id)
    {
        $task = PartnerTask::with(['sponsor', 'deal', 'assignedTo'])
            ->where('partner_id', Auth::id())
            ->findOrFail($id);

        return view('partner.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $task = PartnerTask::where('partner_id', Auth::id())->findOrFail($id);
        $task->status = $validated['status'];
        if ($validated['status'] === 'completed') {
            $task->completed_at = now();
        }
        $task->save();

        return redirect()->route('partner.tasks.index')->with('success', 'Task updated.');
    }
}
