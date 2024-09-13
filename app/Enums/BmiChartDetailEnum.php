<?php

namespace App\Enums;

use Exception;
use Illuminate\Support\Facades\Log;

class BmiChartDetailEnum
{
    const BMI_DETAILS = [
        ['Underweight', 0, 18.4, '#4eb5ff'],
        ['Normal', 18.5, 24.9, '#0ead6a'],
        ['Overweight', 25, 29.9, '#ffdc6a'],
        ['Obesity', 30, 34.9, '#fd9755'],
        ['Obesity 2', 35, 39.9, '#ff5353']
    ];

    // <color name="underweight">#4eb5ff</color>
    // <color name="normal">#0ead6a</color>
    // <color name="Overweight">#ffdc6a</color>
    // <color name="Obesity">#fd9755</color>
    // <color name="Obesity2">#ff5353</color>

    public static function getBmiRanges()
    {
        try {
            $bmiRanges = [];
            foreach (self::BMI_DETAILS as $bmiDetail) {
                $bmiRanges[] = [
                    'min_bmi'    => $bmiDetail[1],
                    'max_bmi'    => $bmiDetail[2],
                    'title'      => $bmiDetail[0],
                    'color_code' => $bmiDetail[3],
                ];
            }
            return $bmiRanges;
        } catch (Exception $e) {
            Log::error('[BmiChartDetailEnum][getBmiRanges] Error fetching BMI ranges', ['exception' => $e]);
            return [];
        }
    }

    public static function getBmiCategory($bmiIndex)
    {
        try {
            foreach (self::BMI_DETAILS as $bmiDetail) {
                if ($bmiIndex >= $bmiDetail[1] && $bmiIndex <= $bmiDetail[2]) {
                    return [
                        'min_bmi' => $bmiDetail[1],
                        'max_bmi' => $bmiDetail[2],
                        'description' => $bmiDetail[0],
                        'color_code' => $bmiDetail[3],
                    ];
                }
            }
            return [];
        } catch (Exception $e) {
            Log::error('[BmiChartDetailEnum][getBmiCategory] Error finding BMI category', ['exception' => $e]);
            return [];
        }
    }
}
