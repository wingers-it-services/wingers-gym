<?php

namespace App\Enums;

enum GymUserAccountStatusEnum
{
    public const NONE = 0;
    public const MOBILE_NUMBER_VERIFIED = 1;
    public const PROFILE_DETAIL_COMPLETED = 2;
    public const EMAIL_VERIFIED = 3;
}
