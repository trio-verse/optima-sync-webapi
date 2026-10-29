<?php

namespace App\Services\Sales;

use App\Enums\enConnectionStages;
use App\Http\Resources\V1\ConnectionResource;
use App\Models\Connection;
use App\Singleton\TenantManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SalesService
{
    private int $organizationId;

    public function __construct(TenantManager $tenantManager)
    {
        $this->organizationId = $tenantManager->getOrganizationId();
    }

    public function getSalesStats(): array
    {
        $connectionsByStage = DB::table('connections')
            ->where('organization_id', $this->organizationId)
            ->select('stage')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw(
                'SUM(CASE WHEN stage = ? THEN COALESCE(deal_value, 0) ELSE 0 END) as won_revenue',
                [enConnectionStages::WIN->value]
            )
            ->groupBy('stage')
            ->get();

        $connectionsCount = (int) $connectionsByStage->sum('count');
        $winCount = (int) $connectionsByStage
            ->firstWhere('stage', enConnectionStages::WIN->value)
            ?->count;
        $wonRevenue = (float) $connectionsByStage
            ->firstWhere('stage', enConnectionStages::WIN->value)
            ?->won_revenue;

        return [
            'client_count' => $this->clientCount(),
            'connections_count' => $connectionsCount,
            'products_count' => $this->productCount(),
            'cities_count' => $this->clientDimensionCount('city_id'),
            'industries_count' => $this->clientDimensionCount('industry_id'),
            'top_products' => $this->topProducts(),
            'winRate' => [
                'percent' => $connectionsCount > 0
                    ? round(($winCount / $connectionsCount) * 100, 2)
                    : 0,
                'winCount' => $winCount,
                'wonRevenue' => $wonRevenue,
            ],
            'connections_by_stage' => $connectionsByStage
                ->map(fn(object $stage): array => [
                    'label' => $stage->stage,
                    'count' => (int) $stage->count,
                ])
                ->values(),
            'clients_by_cities' => $this->clientsByDimension('cities', 'city_id'),
            'clients_by_industries' => $this->clientsByDimension('industries', 'industry_id'),
            'recent_connections' =>  ConnectionResource::collection(
                Connection::query()
                    ->latest()
                    ->limit(5)
                    ->get(),
            )
        ];
    }

    private function clientCount(): int
    {
        return DB::table('clients')
            ->where('organization_id', $this->organizationId)
            ->count();
    }

    private function productCount(): int
    {
        return DB::table('connections')
            ->where('organization_id', $this->organizationId)
            ->distinct('product_id')
            ->count('product_id');
    }

    private function clientDimensionCount(string $column): int
    {
        return DB::table('clients')
            ->where('organization_id', $this->organizationId)
            ->whereNotNull($column)
            ->distinct($column)
            ->count($column);
    }

    private function topProducts(): Collection
    {
        return DB::table('products')
            ->join('connections', function ($join): void {
                $join->on('connections.product_id', '=', 'products.id')
                    ->where('connections.organization_id', $this->organizationId);
            })
            ->select('products.id', 'products.name', 'products.price')
            ->selectRaw('COUNT(connections.id) as connections_count')
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('connections_count')
            ->limit(5)
            ->get()
            ->map(fn(object $product): array => [
                'label' => $product->name,
                'price' => $product->price,
                'connectionsCount' => (int) $product->connections_count,
            ]);
    }

    private function clientsByDimension(string $table, string $foreignKey): Collection
    {
        return DB::table('clients')
            ->join($table, "{$table}.id", '=', "clients.{$foreignKey}")
            ->where('clients.organization_id', $this->organizationId)
            ->select("{$table}.name as label")
            ->selectRaw('COUNT(clients.id) as count')
            ->groupBy("{$table}.name")
            ->orderBy("{$table}.name")
            ->get()
            ->map(fn(object $dimension): array => [
                'label' => $dimension->label,
                'count' => (int) $dimension->count,
            ]);
    }
}
