<?php

namespace App\Http\Controllers\Api;

use App\Enums\BmiChartDetailEnum;
use App\Http\Controllers\Controller;
use App\Models\userBmi;
use App\Models\UserBodyMeasurement;
use App\Traits\errorResponseTrait;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class UserBmiControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userBmi;
    protected $userBodyMeasurement;
    public function __construct(
        userBmi $userBmi, 
        UserBodyMeasurement $userBodyMeasurement)
    {
        $this->userBmi = $userBmi;
        $this->userBodyMeasurement = $userBodyMeasurement;
    }

    public function getUserBmis(Request $request)
    {
        try {
            $request->validate(['gym_id' => 'required|numeric|exists:gyms,id']);

            $bmis = $this->userBmi->where('user_id', auth()->id())
            ->where('gym_id', $request->input('gym_id'))
            ->orderBy('created_at', 'desc')
            ->get();

            if ($bmis->isEmpty()) {
                return $this->errorResponse('Error while fetching user BMIs', 'User BMI list is empty', 422);
            }

            return response()->json([
                'status'  => 200,
                'message' => 'BMIs fetched successfully',
                'bmis'    => $bmis,
            ], 200);
        } catch (Exception $e) {
            Log::error('[userBodyMeasurement][getUserBmis] Error occurred while getting user BMIs', ['error' => $e->getMessage()]);
            return $this->errorResponse('Error occurred while getting user BMIs', $e->getMessage(), 500);
        }
    }

    public function getUserBmiDetails(Request $request)
    {
        try {
            $authUser = auth()->user();
            $request->validate(['bmi_id' => 'required|numeric|exists:user_bmis,id']);
            $bmi_id = $request->input('bmi_id');

            $bodyMeasurement = $this->userBodyMeasurement->where('bmi_id',    $bmi_id)->first();
            if (!$bodyMeasurement) {
                return $this->errorResponse(
                    'Error while fetching user BMI detail',
                    'Body details is empty',
                    422
                );
            }
            if ($bodyMeasurement->user_id !== $authUser->id) {
                return $this->errorResponse(
                    'Error when fetching bmi details',
                    "The bmi id {$bmi_id} does not belong to this user.",
                    422
                );
            }

            $bmiIndex = optional($this->userBmi->where('id', $request->input('bmi_id'))->first())->bmi ?? 0;
            $age = $this->calculateAge($authUser->dob);


            $bmiCategory = BmiChartDetailEnum::getBmiCategory($bmiIndex);

            $fieldsToUpdate = ['chest', 'triceps', 'biceps', 'lats', 'shoulder', 'abs', 'forearms', 'traps', 'glutes', 'quads', 'hamstring', 'calves'];

            // Concatenate "cm" to the specified fields
            foreach ($fieldsToUpdate as $field) {
                if (isset($bodyMeasurement->$field)) {
                    $bodyMeasurement->$field = $bodyMeasurement->$field . ' cm';
                }
            }

            return response()->json([
                'status'            => 200,
                'message'           => 'BMI details fetched successfully',
                'body_measurements' => $bodyMeasurement,
                'bmi_index'         => $bmiIndex,
                'age'               => $age,
                'bmi_title'         => array_key_exists('title', $bmiCategory) ? $bmiCategory['title'] : '',
                'bmi_color_code'    => array_key_exists('color_code', $bmiCategory) ? $bmiCategory['color_code'] : '',
                'chart_data'        => BmiChartDetailEnum::getBmiRanges()
            ], 200);
        } catch (Exception $e) {
            Log::error('[userBodyMeasurement][getUserBmiDetails] Error occurred while getting user BMI detail', ['error' => $e->getMessage()]);
            return $this->errorResponse('Error occurred while getting user BMI detail', $e->getMessage(), 500);
        }
    }

    private function calculateAge($dob): int
    {
        try {
            $birthDate = new DateTime($dob);
            $currentDate = new DateTime();
            $age = $currentDate->diff($birthDate)->y;
            return $age;
        } catch (Exception $e) {
            Log::error('[UserBmiControllerApi][calculateAge] error while calculating user age : ' . $e->getMessage());
            return 0;
        }
    }

    public function addUserBodyMeasurement(Request $request)
    {
        try {
            $request->validate([
                "chest"     => 'required',
                "triceps"   => 'required',
                "biceps"    => 'required',
                "lats"      => 'required',
                "shoulder"  => 'required',
                "abs"       => 'required',
                "forearms"  => 'required',
                "traps"     => 'required',
                "glutes"    => 'required',
                "quads"     => 'required',
                "hamstring" => 'required',
                "calves"    => 'required',
                "height"    => 'required',
                "weight"    => 'required',
                "bmi"       => 'required',
                "month"     => 'required',
                "gym_id"    => 'required|exists:gyms,id'
            ]);
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }
            $userId = $user->id;
            $gymId = $request->gym_id;

            $user->update([
                'height' => $request->height,
                'weight' => $request->weight,
            ]);

            $bmi = $this->userBmi->createBmi($request->all(), $userId, $gymId);

            // Create the body measurement record with the newly created bmi_id
            $boadyMeasurement = $this->userBodyMeasurement->createBodyMeasurement($request->all(), $userId, $gymId, $bmi->id);

            return response()->json([
                'status'           => 200,
                'bmi'              => $bmi,
                'boadyMeasurement' => $boadyMeasurement,
                'message'          => 'Bmi saved successfully'
            ], 200);

            return redirect()->back()->with('status', 'success')->with('message', 'Data saved successfully.');
        } catch (\Throwable $e) {
            Log::error("[UserBmiControllerApi][addUserBodyMeasurement] error " . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error adding bmi details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateUserBmi(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                "chest"     => 'required|numeric',
                "triceps"   => 'required|numeric',
                "biceps"    => 'required|numeric',
                "lats"      => 'required|numeric',
                "shoulder"  => 'required|numeric',
                "abs"       => 'required|numeric',
                "forearms"  => 'required|numeric',
                "traps"     => 'required|numeric',
                "glutes"    => 'required|numeric',
                "quads"     => 'required|numeric',
                "hamstring" => 'required|numeric',
                "calves"    => 'required|numeric',
                "height"    => 'required|numeric',
                "weight"    => 'required|numeric',
                "bmi"       => 'required|numeric',
                "month"     => 'required',
                "gym_id"    => 'required|exists:gyms,id',
                "bmi_id"    => 'required|exists:user_bmis,id'
            ]);
    
            // Authenticate user
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }
    
            $userId = $user->id;
            $gymId = $request->gym_id;
    
            // Update user's height and weight
            $user->update([
                'height' => $request->height,
                'weight' => $request->weight,
            ]);
    
            // Fetch the existing BMI record using bmi_id, user_id, and gym_id
            $bmi = $this->userBmi->where('user_id', $userId)
                                 ->where('gym_id', $gymId)
                                 ->where('id', $request->bmi_id)
                                 ->first();
    
            if ($bmi) {
                // Update existing BMI record
                $bmi->update([
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'bmi'    => $request->bmi,
                ]);
            } else {
                return response()->json([
                    'status'  => 404,
                    'message' => 'BMI record not found.',
                ], 404);
            }
    
            // Fetch the corresponding body measurement record using user_id, gym_id, and bmi_id
            $bodyMeasurement = $this->userBodyMeasurement->where('user_id', $userId)
                                                         ->where('gym_id', $gymId)
                                                         ->where('bmi_id', $bmi->id)
                                                         ->first();
    
            if ($bodyMeasurement) {
                // Update the existing body measurement record
                $bodyMeasurement->update([
                    'chest'      => $request->chest,
                    'triceps'    => $request->triceps,
                    'biceps'     => $request->biceps,
                    'lats'       => $request->lats,
                    'shoulder'   => $request->shoulder,
                    'abs'        => $request->abs,
                    'forearms'   => $request->forearms,
                    'traps'      => $request->traps,
                    'glutes'     => $request->glutes,
                    'quads'      => $request->quads,
                    'hamstring'  => $request->hamstring,
                    'calves'     => $request->calves
                ]);
            } else {
                return response()->json([
                    'status'  => 404,
                    'message' => 'Body measurement record not found.',
                ], 404);
            }
    
            // Return success response with updated data
            return response()->json([
                'status'           => 200,
                'bmi'              => $bmi,
                'bodyMeasurement'  => $bodyMeasurement,
                'message'          => 'BMI and body measurements updated successfully'
            ], 200);
            
        } catch (\Throwable $e) {
            // Log the error and return a 500 response with the error message
            Log::error("[UserBmiControllerApi][updateUserBmi] error: " . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error updating BMI details: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
