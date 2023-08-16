<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\PlaylistBuilder;
use App\Composites\DescriptionComponent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends DescriptionComponent
{
    protected string $table = 'playlists';

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'playlist_tracks');
    }

    public function create(array $data): array|int
    {
        $playlistBuilder = new PlaylistBuilder();
        $result = $playlistBuilder->build($data);

        if ($result instanceof Playlist) {
            $trackslist = $result->trackslist;
            unset($result->trackslist);
            $result->save();
            $playlistId = $result->id;

            foreach ($trackslist as $trackslistItem) {
                $playlistTracks = new PlaylistTracks();
                $playlistTracks->create($playlistId, $trackslistItem);
            }

            return $playlistId;
        }

        return $result;
    }

    public function getList(): Collection
    {
        $playlists = Playlist::with('tracks')->get();

        foreach ($playlists as &$playlist) {
            $totalPlaybackTime = 0;

            foreach ($playlist->tracks as &$playlistTrack) {
                if ($playlistTrack['duration']) {
                    $totalPlaybackTime += $playlistTrack['duration'];
                }

                $this->setDescription($playlistTrack);
            }

            if ($totalPlaybackTime) {
                $playlist->duration = $totalPlaybackTime;
                $this->setDescription($playlist);
            }
        }

        return $playlists;
    }
}
