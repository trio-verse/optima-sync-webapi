<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Pagination\Paginator;

class CityService
{

    public function getAllCities(int $perPage = 15): Paginator
    {
        return City::latest()->simplePaginate($perPage);
    }

    public function createcity(array $data): City
    {

        return City::create($data);
    }

    public function updatecity(array $data, City $city): bool
    {

        return $city->update($data);
    }

    public function deleteCity(City $city): bool
    {
        return $city->delete();
    }
}
