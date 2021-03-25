<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;

/**
 * Static helper class for working with dates.
 */
class DatetimeHelper
{
    /**
     * Get current date and time in UTC timezone.
     * @return DateTime
     */
    public static function getNowUTC()
    {
        return new DateTime("now", new DateTimeZone("UTC"));
    }

    /**
     * From given text construct date and time structure in UTC timezone.
     * @param string $datetime
     * @return DateTime
     */
    public static function createUTC(string $datetime)
    {
        return new DateTime($datetime, new DateTimeZone("UTC"));
    }
}
