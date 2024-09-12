<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\userBmi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class UserBmiControllerApi extends Controller
{

    protected $userBmi;
    public function __construct(userBmi $userBmi)
    {
        $this->userBmi = $userBmi;
    }

    public function getUserBmis(Request $request)
    {
        try {
            $request->validate(['gym_id' => 'required|numeric|exists:gyms,id']);

            $bmis = $this->userBmi->where('user_id', auth()->id())
                ->where('gym_id', $request->input('gym_id'))
                ->get();

            if ($bmis->isEmpty()) {
                return response()->json([
                    'status'      => 422,
                    'message'     => 'Error while fetching user BMIs',
                    'errorMessage' => 'User BMI list is empty'
                ], 422);
            }

            return response()->json([
                'status'  => 200,
                'message' => 'BMIs fetched successfully',
                'bmis'    => $bmis
            ], 200);
        } catch (Exception $e) {
            Log::error('Error occurred while getting user BMIs', ['error' => $e->getMessage()]);
            return response()->json([
                'status'      => 500,
                'message'     => 'Error occurred while getting user BMIs',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }
}
