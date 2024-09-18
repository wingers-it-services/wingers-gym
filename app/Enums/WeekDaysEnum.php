<?php

namespace App\Enums;

class WeekDaysEnum
{
    public const SUNDAY = 1;
    public const MONDAY = 2;
    public const TUESDAY = 3;
    public const WEDNESDAY = 4;
    public const THURSDAY = 5;
    public const FRIDAY = 6;
    public const SATURDAY = 7;

    public static function getWeekDays()
    {
        return [
            self::SUNDAY    => 'Sunday',
            self::MONDAY    => 'Monday',
            self::TUESDAY   => 'Tuesday',
            self::WEDNESDAY => 'Wednesday',
            self::THURSDAY  => 'Thursday',
            self::FRIDAY    => 'Friday',
            self::SATURDAY  => 'Saturday',
        ];
    }
}
