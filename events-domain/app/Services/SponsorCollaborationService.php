<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SponsorApprovalRequest;
use App\Models\SponsorApprovalResponse;
use App\Models\SponsorApprovalStep;
use App\Models\SponsorApprovalWorkflow;
use App\Models\SponsorTask;
use App\Models\SponsorTaskAssignee;
use App\Models\SponsorTeam;
use App\Models\SponsorTeamMember;
use Illuminate\Support\Facades\DB;

class SponsorCollaborationService
{
    // =========================================================================
    // Team Management
    // =========================================================================

    public function createTeam(array $data): SponsorTeam
    {
        return SponsorTeam::create($data);
    }

    public function addTeamMember(SponsorTeam $team, int $userId, string $role): SponsorTeamMember
    {
        return SponsorTeamMember::updateOrCreate(
            ['sponsor_id' => $team->sponsor_id, 'user_id' => $userId],
            ['role' => $role, 'team_id' => $team->id],
        );
    }

    public function removeTeamMember(SponsorTeam $team, int $userId): void
    {
        SponsorTeamMember::where('team_id', $team->id)
            ->where('user_id', $userId)
            ->delete();
    }

    // =========================================================================
    // Task Management
    // =========================================================================

    public function createTask(array $data, array $assigneeIds = []): SponsorTask
    {
        return DB::transaction(function () use ($data, $assigneeIds) {
            $task = SponsorTask::create($data);

            foreach ($assigneeIds as $userId) {
                SponsorTaskAssignee::create([
                    'task_id' => $task->id,
                    'user_id' => $userId,
                ]);
            }

            return $task;
        });
    }

    public function updateTaskStatus(SponsorTask $task, string $status): void
    {
        $data = ['status' => $status];

        if ($status === 'done') {
            $data['completed_at'] = now();
        }

        $task->update($data);
    }

    public function assignTask(SponsorTask $task, int $userId): void
    {
        SponsorTaskAssignee::firstOrCreate([
            'task_id' => $task->id,
            'user_id' => $userId,
        ]);
    }

    public function unassignTask(SponsorTask $task, int $userId): void
    {
        SponsorTaskAssignee::where('task_id', $task->id)
            ->where('user_id', $userId)
            ->delete();
    }

    // =========================================================================
    // Approval Workflows
    // =========================================================================

    public function createWorkflow(array $data, array $steps = []): SponsorApprovalWorkflow
    {
        return DB::transaction(function () use ($data, $steps) {
            $workflow = SponsorApprovalWorkflow::create($data);

            foreach ($steps as $order => $step) {
                SponsorApprovalStep::create([
                    'workflow_id' => $workflow->id,
                    'approver_id' => $step['approver_id'],
                    'step_order' => $order + 1,
                    'action' => $step['action'] ?? 'approve',
                ]);
            }

            return $workflow;
        });
    }

    public function submitForApproval(SponsorApprovalWorkflow $workflow, $approvable, int $userId, ?string $notes = null): SponsorApprovalRequest
    {
        return SponsorApprovalRequest::create([
            'workflow_id' => $workflow->id,
            'approvable_type' => get_class($approvable),
            'approvable_id' => $approvable->id,
            'requested_by' => $userId,
            'status' => 'pending',
            'notes' => $notes,
        ]);
    }

    public function processApproval(SponsorApprovalRequest $request, int $stepId, int $userId, string $decision, ?string $comment = null): void
    {
        DB::transaction(function () use ($request, $stepId, $userId, $decision, $comment) {
            SponsorApprovalResponse::create([
                'approval_request_id' => $request->id,
                'step_id' => $stepId,
                'user_id' => $userId,
                'decision' => $decision,
                'comment' => $comment,
            ]);

            if ($decision === 'rejected') {
                $request->update(['status' => 'rejected', 'resolved_at' => now()]);

                return;
            }

            $approvedCount = $request->responses()
                ->where('decision', 'approved')
                ->count();

            if ($approvedCount >= $request->workflow->steps_required) {
                $request->update(['status' => 'approved', 'resolved_at' => now()]);
            }
        });
    }

    public function getTeamDashboard(int $sponsorId): array
    {
        return [
            'team_count' => SponsorTeam::where('sponsor_id', $sponsorId)->count(),
            'member_count' => SponsorTeamMember::where('sponsor_id', $sponsorId)->count(),
            'pending_tasks' => SponsorTask::where('sponsor_id', $sponsorId)->pending()->count(),
            'overdue_tasks' => SponsorTask::where('sponsor_id', $sponsorId)->overdue()->count(),
            'pending_approvals' => SponsorApprovalRequest::where('status', 'pending')
                ->whereHas('workflow', fn ($q) => $q->where('sponsor_id', $sponsorId))
                ->count(),
        ];
    }
}
