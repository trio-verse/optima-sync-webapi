<?php

namespace App\Http\Controllers;

use App\Http\Requests\City\StoreCityRequest;
use App\Http\Resources\V1\CityResource;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function __construct(protected CityService $city_service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    /**
     * create city.
     * Store a newly created city in data.
     */
    public function store(StoreCityRequest $request)
    {
        $city = $this->city_service->create($request->validated());

        return new CityResource($city);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
