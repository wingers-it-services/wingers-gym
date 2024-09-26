<?php
namespace App\Enums;

enum StaffAttendanceStatusEnum
{
    public const PRESENT = 1;
    public const ABSENT = 0;

    public const HALFDAY = 0.5;
    public const WEEKEND = 3;
    public const HOLIDAY = 4;
}
