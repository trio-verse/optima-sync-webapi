<?php

namespace App\Services\Workspace;

use App\Models\WorksapceModels\Workspace;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class WorkspaceService
{
    public function list(array $filters): LengthAwarePaginator
    {
        $query = Workspace::query()
            ->select(['id', 'name', 'description', 'deadline', 'status', 'created_at', 'updated_at']);

        $this->applyFilters($query, $filters);

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';

        return $query
            ->orderBy($sort, $direction)
            ->paginate((int) ($filters['per_page'] ?? 15))
            ->withQueryString();
    }

    public function create(array $data): Workspace
    {
        return Workspace::query()->create($data);
    }

    public function update(Workspace $workspace, array $data): Workspace
    {
        $workspace->update($data);

        return $workspace->refresh();
    }

    public function delete(Workspace $workspace): void
    {
        $workspace->delete();
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        $query
            ->when(
                $filters['status'] ?? null,
                fn (Builder $query, string $status) => $query->where('status', $status)
            )
            ->when(
                $filters['search'] ?? null,
                fn (Builder $query, string $search) => $query->where(function (Builder $query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                })
            )
            ->when(
                $filters['deadline_from'] ?? null,
                fn (Builder $query, string $deadline) => $query->whereDate('deadline', '>=', $deadline)
            )
            ->when(
                $filters['deadline_to'] ?? null,
                fn (Builder $query, string $deadline) => $query->whereDate('deadline', '<=', $deadline)
            );
    }
}
