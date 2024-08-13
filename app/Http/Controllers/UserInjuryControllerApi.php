<?php

namespace App\Http\Controllers;

use App\Models\UserInjury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserInjuryControllerApi extends Controller
{
    protected $injury;

    public function __construct(UserInjury $injury)
    {
        $this->injury = $injury;
    }

   /**
    * The function fetches user injury types and returns a JSON response with the fetched data or an
    * error message if an exception occurs.
    * 
    * @param Request request The `fetchUserInjury` function is responsible for fetching user injury
    * types. It retrieves all injury types from the database using the `get()` method of the ``
    * model.
    * 
    * @return The function `fetchUserInjury` returns a JSON response with status code 200 if the
    * injuries are successfully fetched. If there are no injuries, it returns a message stating "There
    * is no injury type". If an exception occurs during the process, it returns a JSON response with
    * status code 500 and an error message indicating the issue encountered while fetching the injury
    * type details.
    */
    public function fetchUserInjury(Request $request)
    {
        try {
            $injuries = $this->injury->get();

            if ($injuries->isEmpty()) {
                return response()->json([
                    'status'    => 200,
                    'injuries'  => $injuries,
                    'message'   => 'There is no injury type'
                ], 200);
            }

            return response()->json([
                'status'   => 200,
                'injuries' => $injuries,
                'message'  => 'User injury type Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserInjuryControllerApi][fetchUserInjury]Error fetching injury type details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching injury type details: ' . $e->getMessage()
            ], 500);
        }
    }
}
