<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearchFilter
{
    /**
     * Apply a search filter to a query builder based on multiple columns.
     */
    protected function applySearchFilter(Builder $query, string $search, array $columns): Builder
    {
        return $query->where(function (Builder $q) use ($search, $columns) {
            foreach ($columns as $index => $column) {
                $method = $index === 0 ? 'where' : 'orWhere';
                $q->{$method}($column, 'like', "%{$search}%");
            }
        });
    }

    /**
     * Apply status filter to a query builder.
     */
    protected function applyStatusFilter(Builder $query, ?string $status, string $column = 'status'): Builder
    {
        if ($status && $status !== 'all') {
            $query->where($column, $status);
        }

        return $query;
    }
}
