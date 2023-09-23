<?php

declare(strict_types=1);

namespace App\Music\Domain\Decorator\Track;

class DurationTrackDecorator implements TrackInterface
{
    public function __construct(private readonly TrackInterface $track)
    {
    }

    public function getDuration(): string
    {
        $min = $this->track->getDuration() / 60;
        $sec = $this->track->getDuration() % 60;
        return $min . ':' . $sec;
    }
}
