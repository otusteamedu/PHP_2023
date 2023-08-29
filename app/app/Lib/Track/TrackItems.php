<?php

declare(strict_types=1);

namespace App\Lib\Track;

use App\Lib\Audio\CompositeAudioInterface;

class TrackItems implements CompositeAudioInterface
{
    /**
     * @var array|TrackObject[]
     */
    private array $tracks;

    /**
     * @param array|TrackObject[] $traks
     */
    public function __construct(array $tracks)
    {
        $this->tracks = $tracks;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        $duration = 0;
        foreach ($this->tracks as $track) {
            $duration += $track->getDuration();
        }

        return $duration;
    }

    public function toArray(): array
    {
        $list = [];
        foreach ($this->tracks as $track) {
            $list[] = $track->toArray();
        }

        return $list;
    }

}
