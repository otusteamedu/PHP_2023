<?php

declare(strict_types=1);

namespace App\Lib\Playlist;

use App\Lib\Audio\CompositeAudioInterface;

class PlaylistItems implements CompositeAudioInterface
{
    /**
     * @var array|CompositeAudioInterface[]
     */
    private array $playlist;

    /**
     * @param array|CompositeAudioInterface[] $playlist
     */
    public function __construct(array $playlist)
    {
        $this->playlist = $playlist;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        $duration = 0;
        foreach ($this->playlist as $playlist) {
            $duration += $playlist->getDuration();
        }

        return $duration;
    }

    public function toArray(): array
    {
        $list = [];
        foreach ($this->playlist as $playlist) {
            $list[] = $playlist->toArray();
        }

        return $list;
    }

}
