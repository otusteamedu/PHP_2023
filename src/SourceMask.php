<?php

declare(strict_types=1);

namespace App;

class SourceMask
{
    public static function calculateMaskFromNames(array $sourceNames): int
    {
        $sourceMask = 0;
        foreach ($sourceNames as $name) {
            $sourceMask |= Event::SOURCES[$name];
        }
        return $sourceMask;
    }

    public static function calculateMaskFromSources(array $eventSources): int
    {
        $eventSourceMask = 0;
        foreach ($eventSources as $eventSource) {
            $eventSourceMask |= Event::SOURCES[$eventSource];
        }
        return $eventSourceMask;
    }
}
