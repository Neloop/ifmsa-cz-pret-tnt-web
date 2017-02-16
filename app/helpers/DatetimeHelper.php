<?php

namespace App\Helpers;

class DatetimeHelper
{
    public static function getNowUTC()
    {
        return new \DateTime("now", new \DateTimeZone("UTC"));
    }
}
