<?php

declare(strict_types=1);

namespace App;

class SourceMask
{
    public static function calculateMaskFromNames(array $sourceNames, array $sources): int
    {
        $sourceMask = 0;
        foreach ($sourceNames as $name) {
            $sourceMask |= $sources[$name];
        }
        return $sourceMask;
    }

    public static function calculateMaskFromSources(array $eventSources, array $sources): int
    {
        $eventSourceMask = 0;
        foreach ($eventSources as $eventSource) {
            $eventSourceMask |= $sources[$eventSource];
        }
        return $eventSourceMask;
    }
}
