<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class EventRepository
{
    protected Event $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    // =========================================================================
    // Queries
    // =========================================================================

    public function find(int $id): ?Event
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Event
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug(string $slug): ?Event
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function forOrganizer(int $organizerId): Builder
    {
        return $this->model->where('organizer_id', $organizerId);
    }

    public function published(): Builder
    {
        return $this->model->published();
    }

    public function featured(): Builder
    {
        return $this->model->featured();
    }

    public function upcoming(): Builder
    {
        return $this->model->upcoming();
    }

    public function paginatedForOrganizer(int $organizerId, int $perPage = 15, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->forOrganizer($organizerId);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('city', 'LIKE', "%{$search}%");
            });
        }

        return $query->with('category')->latest()->paginate($perPage);
    }

    public function getOrganizerStats(int $organizerId): array
    {
        $events = $this->forOrganizer($organizerId);

        return [
            'total_events' => (clone $events)->count(),
            'published_events' => (clone $events)->published()->count(),
            'pending_events' => (clone $events)->pending()->count(),
            'total_views' => (clone $events)->sum('views_count'),
        ];
    }

    public function getDashboardEvents(int $organizerId, int $limit = 6): Collection
    {
        return $this->forOrganizer($organizerId)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getPublicEvents(?int $categoryId = null, ?string $city = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->model->published()->upcoming();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($city) {
            $query->where('city', 'LIKE', "%{$city}%");
        }

        return $query->with('category', 'organizer')
            ->latest('start_date')
            ->paginate($perPage);
    }

    // =========================================================================
    // Actions
    // =========================================================================

    public function create(array $data): Event
    {
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }

        return $this->model->create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);

        return $event->fresh();
    }

    public function delete(Event $event): bool
    {
        return $event->delete();
    }

    public function publish(Event $event): Event
    {
        $event->update([
            'approval_status' => 'approved',
            'status' => 'live',
            'is_published' => true,
            'published_at' => now(),
        ]);

        return $event->fresh();
    }

    public function reject(Event $event, ?string $reason = null): Event
    {
        $event->update([
            'approval_status' => 'rejected',
            'status' => 'draft',
            'rejection_reason' => $reason,
        ]);

        return $event->fresh();
    }

    public function submitForReview(Event $event): Event
    {
        $event->update([
            'approval_status' => 'pending',
            'status' => 'pending',
        ]);

        return $event->fresh();
    }

    public function incrementViews(Event $event): void
    {
        $event->increment('views_count');
    }

    public function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = $this->model->where('slug', 'like', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    // =========================================================================
    // Bulk operations
    // =========================================================================

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }

    public function bulkFeature(array $ids, bool $featured = true): int
    {
        return $this->model->whereIn('id', $ids)->update(['is_featured' => $featured]);
    }
}
