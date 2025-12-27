<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Log;

class TimeZoneHelper
{
    public const FORMAT = 'UTC%+03d:%02d';

    public static function formatTZ(?string $tz = null): string
    {
        try {
            $tz = $tz ?? config('app.timezone', 'UTC');
            $dt = new DateTime('now', new DateTimeZone($tz));
            $offsetSeconds = $dt->getOffset();
            $hours = intdiv($offsetSeconds, 3600);
            $minutes = intdiv(abs($offsetSeconds) % 3600, 60);
            return sprintf(self::FORMAT, $hours, $minutes);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' Returning UTC timezone.');
            return 'UTC+00:00';
        }
    }

    public static function generateRandomFormattedTZ(): string
    {
        return sprintf(self::FORMAT,rand(-12, 14), 0);
    }
}
