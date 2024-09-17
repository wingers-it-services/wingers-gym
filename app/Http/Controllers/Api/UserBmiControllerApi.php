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
    public function __construct(userBmi $userBmi, UserBodyMeasurement $userBodyMeasurement)
    {
        $this->userBmi = $userBmi;
        $this->userBodyMeasurement = $userBodyMeasurement;
    }

    public function getUserBmis(Request $request)
    {
        try {
            $request->validate(['gym_id' => 'required|numeric|exists:gyms,id']);

            $bmis = $this->userBmi->where('user_id', auth()->id())->where('gym_id', $request->input('gym_id'))->get();

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

            $bodyMeasurement = $this->userBodyMeasurement->where('bmi_id', $request->input('bmi_id'))->first();
            if ($bodyMeasurement && $bodyMeasurement->user_id !== $authUser->id) {
                return $this->errorResponse(
                    'Error when fetching bmi details',
                    "The bmi id {$request->input('bmi_id')} does not belong to this user.",
                    422
                );
            }

            $bmiIndex = optional($this->userBmi->where('id', $request->input('bmi_id'))->first())->bmi ?? 0;
            $age = $this->calculateAge($authUser->dob);

            if (!$bodyMeasurement) {
                return $this->errorResponse('Error while fetching user BMI detail', 'Body details is empty', 422);
            }
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
}
