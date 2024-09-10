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
            self::PRESENT => '#8fbc8f',
            self::ABSENT => '#cd5c5c', 
            self::WEEKEND => '#808080',
            self::HOLIDAY => '#deb887',
            default => '#FFFFFF',      
        };
    }
}
