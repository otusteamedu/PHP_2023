<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Entity\Event;
use App\Domain\ValueObject\Source;

class SourceMaskHandler
{
    public static function calculateMaskFromNames(array $sourceNames): int
    {
        $sourceMask = 0;
        foreach ($sourceNames as $name) {
            $sourceMask |= Event::SOURCES[$name];
        }
        return $sourceMask;
    }

    public static function calculateMaskFromSources(Source $source): int
    {
        $eventSourceMask = 0;
        foreach ($source->getSources() as $eventSource) {
            $eventSourceMask |= Event::SOURCES[$eventSource];
        }
        return $eventSourceMask;
    }
}
