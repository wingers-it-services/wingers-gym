<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Gym;
use App\Traits\errorResponseTrait;
use Illuminate\Support\Facades\Log;
use Throwable;

class LocationControllerApi extends Controller
{
    
    use errorResponseTrait;
    protected $country;
    protected $state;
    protected $city;
    protected $gym;

    public function __construct(
        Country $country,
        State $state,
        City $city,
        Gym $gym
    ) {
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
        $this->gym = $gym;
    }

   /**
    * The fetchCountryList function retrieves a list of countries and returns it as a JSON response.
    * 
    * @return A JSON response containing a list of all countries fetched from the database.
    */
    public function fetchCountryList()
    {
        $countries = $this->country->all();
        return response()->json($countries);
    }

    /**
     * This PHP function fetches a list of states based on a provided country ID and handles any errors
     * that may occur during the process.
     * 
     * @param Request request The `fetchStateList` function is a PHP function that takes a `Request`
     * object as a parameter. This function is responsible for fetching a list of states based on the
     * provided `countryId` in the request.
     * 
     * @return An array of states based on the provided countryId is being returned as a JSON response.
     */
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

   /**
    * This PHP function fetches a list of cities based on a provided state ID and handles any errors
    * that may occur during the process.
    * 
    * @param Request request The `fetchCityList` function is a PHP method that takes a `Request` object
    * as a parameter. This function is responsible for fetching a list of cities based on the provided
    * `stateId` parameter.
    * 
    * @return The `fetchCityList` function returns a JSON response containing a list of cities based on
    * the provided `stateId`. If an error occurs during the process, an error response with a message
    * indicating the issue is returned.
    */
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

  /**
   * This PHP function fetches gyms based on a specified city ID and handles errors gracefully.
   * 
   * @param Request request The `fetchGymsByCity` function is a controller method that fetches gyms
   * based on the `cityId` provided in the request. Here's a breakdown of the code:
   * 
   * @return The `fetchGymsByCity` function returns a JSON response containing a list of gyms that
   * belong to a specific city based on the `cityId` provided in the request. If an error occurs during
   * the process of fetching gyms, an error response with a message indicating the issue is returned.
   */
    public function fetchGymsByCity(Request $request)
    {
        try {
            $request->validate([
                'cityId' => 'required|exists:cities,id', // Ensure cityId exists in the cities table
            ]);

            $cityId = $request->input('cityId');
            $gyms = $this->gym->where('city_id', $cityId)->get();
            return response()->json($gyms);
        } catch (Throwable $e) {
            Log::error("[LocationControllerApi][fetchGymsByCity] Error fetching gyms: " . $e->getMessage());
            return $this->errorResponse('Error while fetching gyms', $e->getMessage(), 500);
        }
    }
}
