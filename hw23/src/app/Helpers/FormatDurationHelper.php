<?php

namespace App\Helpers;

class FormatDurationHelper
{
    public static function formatDuration(int $duration): string
    {
        $seconds = floor($duration % 60);
        $minutes = floor($duration / 60);

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
