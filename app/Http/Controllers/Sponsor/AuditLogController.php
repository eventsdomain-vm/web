<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorAuditLog;
use App\Services\SponsorAdminService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function __construct(
        protected SponsorAdminService $adminService,
    ) {}

    protected function getSponsorId(): ?int
    {
        return Sponsor::where('user_id', auth()->id())->value('id');
    }

    public function index(Request $request): View
    {
        $sponsorId = $this->getSponsorId();

        $filters = $request->only(['action', 'auditable_type', 'from', 'to']);

        $result = $sponsorId
            ? $this->adminService->getAuditTrail($sponsorId, $filters)
            : ['logs' => [], 'total' => 0, 'actions' => collect()];

        $actions = $sponsorId
            ? SponsorAuditLog::where('sponsor_id', $sponsorId)->selectRaw('DISTINCT action')->pluck('action')
            : collect();

        return view('sponsor.audit-logs.index', [
            'logs' => $result['logs'],
            'total' => $result['total'],
            'actions' => $actions,
            'filters' => $filters,
        ]);
    }
}
