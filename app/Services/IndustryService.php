<?php

namespace App\Services;

use App\Models\Industry;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class IndustryService
{

    public function getAllIndustries(int $perPage = 15): Paginator
    {
        return Industry::latest()->simplePaginate($perPage);
    }

    public function create(array $data): Industry
    {
        return DB::transaction(function () use ($data) {
            return Industry::create($data);
        });
    }

    public function update(array $data, Industry $industry): Industry
    {
        DB::transaction(function () use ($data, $industry) {
            $industry->updateOrFail($data);
        });

        return $industry->refresh();
    }

    public function delete(Industry $industry): bool
    {
        return DB::transaction(function () use ($industry) {
            $industry->deleteOrFail();
            return true;
        });
    }
}
