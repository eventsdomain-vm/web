<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorTask;
use App\Services\SponsorCollaborationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(
        protected SponsorCollaborationService $collaborationService,
    ) {}

    protected function getSponsorId(): ?int
    {
        return Sponsor::where('user_id', auth()->id())->value('id');
    }

    public function index(): View
    {
        $sponsorId = $this->getSponsorId();

        $tasks = $sponsorId
            ? SponsorTask::where('sponsor_id', $sponsorId)
                ->with(['assignees.user', 'creator', 'campaign'])
                ->latest()
                ->paginate(20)
            : collect();

        return view('sponsor.tasks.index', compact('tasks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId) {
            return back()->with('error', 'Sponsor profile not found.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'campaign_id' => 'nullable|exists:sponsor_campaigns,id',
            'contract_id' => 'nullable|exists:sponsorship_contracts,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'assignees' => 'nullable|array',
            'assignees.*' => 'exists:users,id',
        ]);

        $assignees = $validated['assignees'] ?? [];
        unset($validated['assignees']);

        $this->collaborationService->createTask([
            'sponsor_id' => $sponsorId,
            'created_by' => auth()->id(),
            ...$validated,
        ], $assignees);

        return redirect()->route('sponsor.tasks.index')
            ->with('success', 'Task created.');
    }

    public function update(Request $request, SponsorTask $task): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId || $task->sponsor_id !== $sponsorId) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,review,done,cancelled',
        ]);

        $this->collaborationService->updateTaskStatus($task, $validated['status']);

        return redirect()->route('sponsor.tasks.index')
            ->with('success', 'Task updated.');
    }
}
