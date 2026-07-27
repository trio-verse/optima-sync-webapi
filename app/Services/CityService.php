<?php

namespace App\Services;

use App\Models\City;

class CityService
{

    public function create(array $data): City
    {

        return City::create($data);
    }
}
