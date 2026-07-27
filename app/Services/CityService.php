<?php

namespace App\Services;

use App\Models\City;

class CityService
{

    public function create(array $data): City
    {

        return City::create($data);
    }

    public function update(array $data , City $city):bool{
        return $city->update($data);
    }
}
