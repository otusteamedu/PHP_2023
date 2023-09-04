<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Functions;

function convertFromStringToInt(string $duration): int
{
    return empty($duration) ? 0 : strtotime($duration);
}

function convertFromIntToString(int $duration): string
{
    return date("H:i:s", $duration);
}
