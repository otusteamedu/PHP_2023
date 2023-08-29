<?php

declare(strict_types=1);

namespace App\Lib\Playlist;

use App\Lib\Audio\CompositeAudioInterface;
use App\Lib\Track\TrackObject;

class PlaylistObject implements CompositeAudioInterface
{
    /**
     * @var array|CompositeAudioInterface[]
     */
    private array $tracks;
    private string $name;
    private int $userId;

    /**
     * @param TrackObject[]|array $tracks
     * @param string $name
     * @param int $userId
     */
    public function __construct(array $tracks, string $name, int $userId)
    {
        $this->tracks = $tracks;
        $this->name = $name;
        $this->userId = $userId;
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

    /**
     * @return array
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        $list = [];

        foreach ($this->tracks as $track) {
            $list[] = $track->toArray();
        }
        return [
            'name' => $this->name,
            '$this->userId' => $this->userId,
            'tracks' => $list,
        ];
    }

}
