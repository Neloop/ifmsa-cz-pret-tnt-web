<?php

namespace App\Helpers;

class DatetimeHelper
{
    public static function getNowUTC()
    {
        return new \DateTime("now", new \DateTimeZone("UTC"));
    }

    public static function createUTC(string $datetime)
    {
        return new \DateTime($datetime, new \DateTimeZone("UTC"));
    }
}
