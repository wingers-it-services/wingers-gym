<?php

namespace App\Http\Controllers;

use App\Models\Suppliment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplimentControllerApi extends Controller
{
    protected $suppliment;

    public function __construct(Suppliment $suppliment)
    {
        $this->suppliment = $suppliment;
    }

   /**
    * The function fetches a list of supplements and returns a JSON response with the status and
    * message.
    * 
    * @return The `fetchSuppliments` function returns a JSON response with status code 200 if
    * suppliments are found, and status code 500 if there is an error.
    */
    public function fetchSuppliments()
    {
        try {
            $suppliments = $this->suppliment->paginate(10);

            if ($suppliments->isEmpty()) {
                return response()->json([
                    'status'      => 200,
                    'suppliments' => $suppliments,
                    'message'     => 'There is no suppliment.'
                ], 200);
            }

            return response()->json([
                'status'      => 200,
                'suppliments' => $suppliments,
                'message'     => 'Suppliment Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[SupplimentControllerApi][fetchSuppliments]Error fetching suppliment details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching suppliment details: ' . $e->getMessage()
            ], 500);
        }
    }
}
