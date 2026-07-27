<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Helper\V1\ApiResponse;
use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
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
     * create city
     * this endpoint create new city
     * response new city
     */
    public function store(StoreCityRequest $request)
    {
        $city = $this->city_service->create($request->validated());

        return ApiResponse::response(new CityResource($city), 'The city was created succsesfully', 201);
    }


    /**
     * Update city
     * this endpoint update city data
     * response updated city data
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $is_updated = $this->city_service->update($request->validated(), $city);
        if ($is_updated) {
            return ApiResponse::response(new CityResource($city), 'The city was updated succsesfully', 200);;
        } else   return ApiResponse::error(null, "bad request", 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
