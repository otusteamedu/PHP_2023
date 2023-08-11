<?php

namespace App\Builders;

use App\Models\Playlist;
use App\Models\Track;

class PlaylistBuilder
{
    public Playlist $playlist;

    public function __construct()
    {
        $this->playlist = new Playlist();
    }

    public function build(array $data): Playlist|array
    {
        $errors = [];

        if (isset($data['name']) && !empty($data['name'])) {
            $this->playlist->name = $data['name'];
        } else {
            $errors[] = 'Playlist name is missing';
        }

        if (isset($data['tracks-list']) && !empty($data['tracks-list'])) {
            if (is_array($data['tracks-list'])) {
                $trackIds = [];

                foreach ($data['tracks-list'] as $listItem) {
                    $trackId = false;

                    if (is_array($listItem)) {
                        $track = new Track();
                        $result = $track->create($listItem);

                        if (is_int($result)) {
                            $trackId = $result;
                        } else {
                            $errors[] = [
                                'message' => 'Track was not created',
                                'reasons' => $result,
                                'resource' => $listItem,
                            ];
                        }
                    } elseif (is_int($listItem)) {
                        $trackId = $listItem;
                    }

                    if ($trackId) {
                        $trackIds[] = $trackId;
                    }
                }

                $this->playlist->trackslist = $trackIds;
            } else {
                $errors[] = 'Incorrect format of list of tracks';
            }
        }

        if ($errors) {
            return $errors;
        }
        return $this->playlist;
    }
}
