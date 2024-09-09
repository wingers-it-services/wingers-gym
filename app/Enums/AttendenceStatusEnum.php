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
            self::PRESENT => 'green',
            self::ABSENT => 'red',
            self::WEEKEND => 'gray',
            self::HOLIDAY => 'blue',
            default => 'black', // Default color for unknown status
        };
    }
}
