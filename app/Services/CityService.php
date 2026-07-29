<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CityService
{

    public function getAllCities(int $perPage = 15): Paginator
    {
        return City::latest()->simplePaginate($perPage);
    }

    public function createcity(array $data): City
    {
        return DB::transaction(function () use ($data) {
            return City::create($data);
        });
    }

    public function updatecity(array $data, City $city): bool
    {
        return DB::transaction(function () use ($data, $city) {
            return $city->update($data);
        });
    }

    public function deleteCity(City $city): bool
    {
        return DB::transaction(function () use ($city) {
            return $city->delete();
        });
    }
}
