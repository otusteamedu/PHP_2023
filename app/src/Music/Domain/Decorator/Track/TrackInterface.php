<?php

declare(strict_types=1);

namespace App\Music\Domain\Decorator\Track;

interface TrackInterface
{
    public function getDuration(): int|string;
}
