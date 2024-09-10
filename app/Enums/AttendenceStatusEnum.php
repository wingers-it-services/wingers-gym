<?php
namespace App\Enums;

enum AttendenceStatusEnum
{
    public const PRESENT = 1;
    public const ABSENT = 2;
    public const WEEKEND = 3;
    public const HOLIDAY = 4;

    public static function getColor($status)
    {
        return match ($status) {
            self::PRESENT => 'green',   // Green for present
            self::ABSENT => 'red',      // Red for absent
            self::WEEKEND => 'gray',    // Gray for weekend
            self::HOLIDAY => 'blue',    // Blue for holiday
            default => 'black',         // Black for unknown
        };
    }
}
