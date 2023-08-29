<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Lib\Playlist\PlaylistItems;
use App\Lib\Playlist\PlaylistObject;
use App\Lib\Track\TrackBuilder;
use App\Models\Playlist;

class ServicePlaylist
{
    private Playlist $playlist;

    public function __construct(
        Playlist $playlist
    ) {
        $this->playlist = $playlist;
    }

    public function add(array $data): void
    {
        $f = $this->playlist->create([
            'name' => $data['name'],
            'user_id' => $data['user_id']
        ]);

        if (!empty($data['tracks'])) {
            $f->tracks()->attach($data['tracks']);
        }
    }

    /**
     * @param int $userId
     * @return PlaylistItems
     */
    public function getListUserId(int $userId): PlaylistItems
    {
        $list = $this->playlist->where('user_id', $userId)->get();

        $items = [];
        foreach ($list as $item) {
            $tracks = $item->tracks()->get();
            $trackList = [];
            foreach ($tracks as $track) {
                $builder = new TrackBuilder(
                    $track->getAttribute('name'),
                    $track->getAttribute('author'),
                    (int)$track->getAttribute('genre_id'),
                    (int)$track->getAttribute('duration'),
                    $track->getAttribute('file')
                );
                $trackList[] = $builder->build();
            }
            $items[] = new PlaylistObject(
                $trackList,
                $item->getAttribute('name'),
                $item->getAttribute('user_id')
            );
        }
        return new PlaylistItems($items);
    }
}
