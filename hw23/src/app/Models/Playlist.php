<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\PlaylistBuilder;
use App\Decorators\TrackDescriptionDecorator;
use App\Helpers\FormatDurationHelper;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected string $table = 'playlists';

    public function tracks()
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

    public function getList()
    {
        $playlists = Playlist::with('tracks')->get();

        foreach ($playlists as $playlistKey => $playlist) {
            $totalPlaybackTime = 0;

            foreach ($playlist->tracks as $trackKey => $playlistTrack) {
                if ($playlistTrack['duration']) {
                    $totalPlaybackTime += $playlistTrack['duration'];
                }

                $descriptionDecorator = new TrackDescriptionDecorator($playlistTrack, $playlistTrack['description']);
                $playlistTrack['description'] = $descriptionDecorator->decorate();

                $playlist->tracks[$trackKey] = $playlistTrack;
            }

            if ($totalPlaybackTime) {
                $duration = FormatDurationHelper::formatDuration($totalPlaybackTime);
                $playlists[$playlistKey]['duration'] = 'Playback time: ' . $duration;
            }
        }

        return $playlists;
    }
}
