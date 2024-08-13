<?php

namespace App\Http\Controllers;

use App\Models\UserLebel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserLevelControllerApi extends Controller
{
    protected $level;

    public function __construct(UserLebel $level)
    {
        $this->level = $level;
    }

   /**
    * This PHP function fetches user levels and returns a JSON response with the fetched data or an
    * error message if there is an issue.
    * 
    * @param Request request The `fetchLevel` function is responsible for fetching user levels. It
    * retrieves the levels from the database and returns a JSON response with the levels if they exist,
    * along with a status and message.
    * 
    * @return The `fetchLevel` function returns a JSON response with status code, levels data, and a
    * message.
    */
    public function fetchLevel(Request $request)
    {
        try {
            $levels = $this->level->get();

            if ($levels->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'levels'   => $levels,
                    'message'  => 'There is no level'
                ], 200);
            }

            return response()->json([
                'status'  => 200,
                'levels'  => $levels,
                'message' => 'User level Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserLevelControllerApi][fetchLevel]Error fetching level details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching level details: ' . $e->getMessage()
            ], 500);
        }
    }
}
