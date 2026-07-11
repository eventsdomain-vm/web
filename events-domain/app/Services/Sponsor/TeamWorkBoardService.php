<?php

declare(strict_types=1);

namespace App\Services;

class TeamWorkBoardService
{
    public function getWorkBoard(int $userId): array
    {
        $sponsor = Sponsor::where('user_id', $userId)->first();

        if (! $sponsor) {
            return [
                'has_profile' => false,
                'tasks' => [],
                'announcements' => [],
                'approvals' => [],
                'upcoming_deadlines' => [],
                'quick_actions' => [],
            ];
        }

        $sponsorId = $sponsor->id;

        $tasks = $this->getTasksForSponsor($sponsorId);
        $announcements = $this->getAnnouncementsForSponsor($sponsorId);
        $approvals = $this->getApprovalsForSponsor($sponsorId);
        $upcomingDeadlines = $this->getUpcomingDeadlines($sponsorId);
        $quickActions = $this->getQuickActions($sponsorId);

        return [
            'tasks' => $tasks,
            'announcements' => $announcements,
            'approvals' => $approvals,
            'upcoming_deadlines' => $upcomingDeadlines,
            'quick_actions' => $quickActions,
            'stats' => [
                'total_tasks' => count($tasks),
                'completed_tasks' => collect($tasks)->where('status', 'completed')->count(),
                'pending_tasks' => collect($tasks)->whereIn('status', ['todo', 'in_progress'])->count(),
                'new_announcements' => count(array_filter($announcements, fn ($a) => $a['is_new'])),
                'pending_approvals' => count($approvals),
                'urgent_deadlines' => count(array_filter($upcomingDeadlines, fn ($d) => $d['urgency'] === 'urgent')),
            ],
        ];
    }

    private function getTasksForSponsor(int $sponsorId): array
    {
        $tasks = [
            [
                'id' => 'tsk-001',
                'title' => 'Review Proposal for Tech Summit 2024',
                'description' => 'Review and provide feedback on the proposal for Tech Summit client',
                'status' => 'in_progress',
                'priority' => 'high',
                'assigned_to' => ['Sarah Johnson', 'Mike Chen'],
                'deadline' => now()->addDays(3),
                'progress' => 65,
                'tags' => ['proposal', 'client', 'tech'],
                'created_at' => now()->subDays(2),
            ],
            [
                'id' => 'tsk-002',
                'title' => 'Finalize Brand Assets for Product Launch',
                'description' => 'Complete brand guidelines and social media assets for the Q4 product launch',
                'status' => 'todo',
                'priority' => 'urgent',
                'assigned_to' => ['Creative Team'],
                'deadline' => now()->addDays(1),
                'progress' => 0,
                'tags' => ['brand', 'launch', 'creative'],
                'created_at' => now()->subDays(1),
            ],
            [
                'id' => 'tsk-003',
                'title' => 'Update Contract Terms with Event Organizer',
                'description' => 'Negotiate and update contract terms for upcoming event partnership',
                'status' => 'todo',
                'priority' => 'medium',
                'assigned_to' => ['Legal Team'],
                'deadline' => now()->addDays(5),
                'progress' => 0,
                'tags' => ['contract', 'legal'],
                'created_at' => now()->subDays(3),
            ],
            [
                'id' => 'tsk-004',
                'title' => 'Process Invoice from Design Agency',
                'description' => 'Review and approve invoice for design services',
                'status' => 'completed',
                'priority' => 'low',
                'assigned_to' => ['Finance Team'],
                'deadline' => now()->subDays(2),
                'progress' => 100,
                'tags' => ['invoice', 'finance'],
                'created_at' => now()->subDays(10),
            ],
        ];

        return $tasks;
    }

    private function getAnnouncementsForSponsor(int $sponsorId): array
    {
        $announcements = [
            [
                'id' => 'ann-001',
                'title' => 'New Event Platform Updates',
                'content' => 'We have updated our event platform with new features including live streaming and enhanced RSVP capabilities.',
                'type' => 'information',
                'is_new' => true,
                'created_at' => now()->subHours(2),
                'deadline' => null,
            ],
            [
                'id' => 'ann-002',
                'title' => 'Important: Policy Changes for Sponsorship Agreements',
                'content' => 'Please review the updated policies regarding cancellation, refunds, and deliverables for all new sponsorship agreements starting January 2025.',
                'type' => 'important',
                'is_new' => true,
                'created_at' => now()->subHours(24),
                'deadline' => now()->addDays(7),
            ],
            [
                'id' => 'ann-003',
                'title' => 'System Maintenance Scheduled',
                'content' => 'The platform will be undergoing maintenance this Saturday from 2 AM to 6 AM UTC. Some features may be temporarily unavailable.',
                'type' => 'warning',
                'is_new' => false,
                'created_at' => now()->subDays(2),
                'deadline' => null,
            ],
        ];

        return $announcements;
    }

    private function getApprovalsForSponsor(int $sponsorId): array
    {
        $approvals = [
            [
                'id' => 'appr-001',
                'type' => 'proposal_acceptance',
                'title' => 'Tech Summit 2024 Proposal - Review Required',
                'description' => 'Sarah Johnson has submitted a proposal for Tech Summit. Please review and approve or reject.',
                'submitted_by' => 'Sarah Johnson',
                'submitted_at' => now()->subDays(1),
                'urgency' => 'high',
                'amount' => 45000,
                'event_name' => 'Tech Summit 2024',
            ],
            [
                'id' => 'appr-002',
                'type' => 'budget_allocation',
                'title' => 'Q4 Marketing Budget - Approve',
                'description' => 'Please approve the Q4 marketing budget allocation of ₹2,50,000 for digital campaigns.',
                'submitted_by' => 'Marketing Director',
                'submitted_at' => now()->subDays(2),
                'urgency' => 'medium',
                'amount' => 250000,
                'category' => 'Digital Marketing',
            ],
        ];

        return $approvals;
    }

    private function getUpcomingDeadlines(int $sponsorId): array
    {
        $deadlines = [
            [
                'id' => 'dead-001',
                'title' => 'Proposal Submission Deadline',
                'description' => 'Tech Summit 2024 proposal submission deadline',
                'due_date' => now()->addDays(2),
                'urgency' => 'urgent',
                'type' => 'proposal',
                'assigned_to' => ['Sarah Johnson', 'Mike Chen'],
            ],
            [
                'id' => 'dead-002',
                'title' => 'Brand Assets Final Version',
                'description' => 'Final brand assets for Q4 product launch due',
                'due_date' => now()->addDays(1),
                'urgency' => 'urgent',
                'type' => 'creative',
                'assigned_to' => ['Creative Team'],
            ],
            [
                'id' => 'dead-003',
                'title' => 'Contract Renewal - Event Organizer',
                'description' => 'Renewal decision deadline for year-end contract with Event Organizer',
                'due_date' => now()->addDays(4),
                'urgency' => 'medium',
                'type' => 'contract',
                'assigned_to' => ['Legal Team'],
            ],
            [
                'id' => 'dead-004',
                'title' => 'Finance Report Submission',
                'description' => 'Q3 financial reports and reconciliation due',
                'due_date' => now()->addDays(7),
                'urgency' => 'low',
                'type' => 'financial',
                'assigned_to' => ['Finance Team'],
            ],
        ];

        return $deadlines;
    }

    private function getQuickActions(int $sponsorId): array
    {
        return [
            [
                'title' => 'Create New Proposal',
                'description' => 'Start a new sponsorship proposal for an event',
                'icon' => 'plus',
                'route' => '/sponsor/proposals/create',
                'color' => 'terracotta',
            ],
            [
                'title' => 'Browse Events',
                'description' => 'Find new sponsorship opportunities',
                'icon' => 'search',
                'route' => '/sponsor/events',
                'color' => 'blue',
            ],
            [
                'title' => 'Update Budget',
                'description' => 'Adjust fiscal year budget allocations',
                'icon' => 'dollar',
                'route' => '/sponsor/plan/budgets',
                'color' => 'green',
            ],
            [
                'title' => 'View Analytics',
                'description' => 'Check ROI and performance metrics',
                'icon' => 'chart',
                'route' => '/sponsor/analytics',
                'color' => 'purple',
            ],
        ];
    }
}
