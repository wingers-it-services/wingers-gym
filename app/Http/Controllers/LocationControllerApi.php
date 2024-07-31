<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Traits\errorResponseTrait;
use Illuminate\Support\Facades\Log;
use Throwable;

class LocationControllerApi extends Controller
{
    
    use errorResponseTrait;
    protected $country;
    protected $state;
    protected $city;

    public function __construct(
        Country $country,
        State $state,
        City $city
    ) {
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
    }

    public function fetchCountryList()
    {
        $countries = $this->country->all();
        return response()->json($countries);
    }

    public function fetchStateList(Request $request)
    {
        try {
            $request->validate([
                'countryId' => 'required',
            ]);

            $countryId = $request->input('countryId');
            $states = $this->state->where('countryId', $countryId)->get();
            return response()->json($states);
        } catch (Throwable $e) {
            Log::error("[LocationControllerApi][fetchStateList] Error fetching state: " . $e->getMessage());
            return $this->errorResponse('Error while fetching state', $e->getMessage(), 500);
        }
    }

    public function fetchCityList(Request $request)
    {
        try {
            $request->validate([
                'stateId'   => 'required',
            ]);
            $stateId = $request->input('stateId');
            $cities = $this->city->where('stateId', $stateId)->get();
            return response()->json($cities);
        } catch (Throwable $e) {   
              Log::error("[LocationControllerApi][fetchCityList] Error fetching city: " . $e->getMessage());
            return $this->errorResponse('Error while fetching city', $e->getMessage(), 500);
       
        }
    }
}
