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

    public static function getBmiRanges()
    {
        try {
            $bmiRanges = [];
            foreach (self::BMI_DETAILS as $bmiDetail) {
                $categoryKey = strtolower(str_replace(' ', '_', $bmiDetail[0])); // Convert title to key format
                $bmiRanges[$categoryKey] = [
                    'title'      => $bmiDetail[0],
                    'range'      => $bmiDetail[2],
                    'color_code' => $bmiDetail[3]
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
                        'title'      => $bmiDetail[0],
                        'range'      => $bmiDetail[2],
                        'color_code' => $bmiDetail[3]
                    ];
                }
            }
            $defaultCategory = self::BMI_DETAILS[4];
            return [
                'title'      => $defaultCategory[0],
                'range'      => $defaultCategory[2],
                'color_code' => $defaultCategory[3]
            ];
        } catch (Exception $e) {
            Log::error('[BmiChartDetailEnum][getBmiCategory] Error finding BMI category', ['exception' => $e]);
            $defaultCategory =self::BMI_DETAILS[4];
            return [
                'title'      => $defaultCategory[0],
                'range'      => $defaultCategory[2],
                'color_code' => $defaultCategory[3]
            ];
        }
    }

    public static function getChartData()
    {
        try {
            $chartData = [];
            foreach (self::BMI_DETAILS as $bmiDetail) {
                $categoryKey = strtolower(str_replace(' ', '_', $bmiDetail[0]));
                $chartData[$categoryKey] = [
                    'value'    => $bmiDetail[2],
                    'title'    => $bmiDetail[0],
                    'color_code' => $bmiDetail[3],
                ];
            }
            return $chartData;
        } catch (Exception $e) {
            Log::error('[BmiChartDetailEnum][getChartData] Error fetching chart data', ['exception' => $e]);
            return [];
        }
    }
}
