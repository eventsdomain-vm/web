<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SponsorAuditLog;
use App\Models\SponsorDocument;
use App\Models\SponsorDocumentVersion;
use App\Models\SponsorIntegration;
use App\Models\SponsorIntegrationLog;

class SponsorAdminService
{
    // =========================================================================
    // Integration Management
    // =========================================================================

    public function connectIntegration(array $data): SponsorIntegration
    {
        return SponsorIntegration::create($data);
    }

    public function disconnectIntegration(SponsorIntegration $integration): void
    {
        $integration->update(['status' => 'disconnected']);
    }

    public function logIntegrationEvent(SponsorIntegration $integration, string $event, string $status, ?string $details = null, int $records = 0): SponsorIntegrationLog
    {
        return SponsorIntegrationLog::create([
            'integration_id' => $integration->id,
            'event' => $event,
            'details' => $details,
            'status' => $status,
            'records_processed' => $records,
        ]);
    }

    // =========================================================================
    // Document Management
    // =========================================================================

    public function uploadDocument(array $data): SponsorDocument
    {
        return SponsorDocument::create($data);
    }

    public function createDocumentVersion(SponsorDocument $document, array $data): SponsorDocumentVersion
    {
        $latestVersion = $document->versions()->max('version_number') ?? 0;

        $data['document_id'] = $document->id;
        $data['version_number'] = $latestVersion + 1;

        return SponsorDocumentVersion::create($data);
    }

    public function finalizeDocument(SponsorDocument $document): void
    {
        $document->update(['status' => 'final']);
    }

    // =========================================================================
    // Audit Logging
    // =========================================================================

    public function logAction(int $sponsorId, int $userId, string $action, $auditable, array $oldValues = [], array $newValues = [], ?string $description = null): SponsorAuditLog
    {
        $request = request();

        return SponsorAuditLog::create([
            'sponsor_id' => $sponsorId,
            'user_id' => $userId,
            'action' => $action,
            'auditable_type' => get_class($auditable),
            'auditable_id' => $auditable->id,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }

    public function getAuditTrail(int $sponsorId, array $filters = []): array
    {
        $query = SponsorAuditLog::where('sponsor_id', $sponsorId)->with('user');

        if (! empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (! empty($filters['auditable_type'])) {
            $query->where('auditable_type', $filters['auditable_type']);
        }

        if (! empty($filters['from'])) {
            $query->where('created_at', '>=', $filters['from']);
        }

        if (! empty($filters['to'])) {
            $query->where('created_at', '<=', $filters['to']);
        }

        $logs = $query->latest()->paginate($filters['per_page'] ?? 50);

        return [
            'logs' => $logs->items(),
            'total' => $logs->total(),
            'per_page' => $logs->perPage(),
            'current_page' => $logs->currentPage(),
        ];
    }

    // =========================================================================
    // Dashboard Analytics
    // =========================================================================

    public function getAdminDashboard(int $sponsorId): array
    {
        return [
            'integrations' => [
                'total' => SponsorIntegration::where('sponsor_id', $sponsorId)->count(),
                'connected' => SponsorIntegration::where('sponsor_id', $sponsorId)->where('status', 'connected')->count(),
                'errors' => SponsorIntegration::where('sponsor_id', $sponsorId)->where('status', 'error')->count(),
            ],
            'documents' => [
                'total' => SponsorDocument::where('sponsor_id', $sponsorId)->count(),
                'draft' => SponsorDocument::where('sponsor_id', $sponsorId)->where('status', 'draft')->count(),
                'final' => SponsorDocument::where('sponsor_id', $sponsorId)->where('status', 'final')->count(),
            ],
            'recent_activity' => SponsorAuditLog::where('sponsor_id', $sponsorId)
                ->with('user')
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
}
