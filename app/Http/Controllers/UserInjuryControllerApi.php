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

    public function fetchUserInjury(Request $request)
    {
        try {
            $injury = $this->injury->get();

            if ($injury->isEmpty()) {
                return response()->json([
                    'status'      => 200,
                    'injury'        => $injury,
                    'message'     => 'There is no injury type'
                ], 200);
            }

            return response()->json([
                'status'      => 200,
                'injury'        => $injury,
                'message'     => 'User injury type Fetch Successfully'
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
