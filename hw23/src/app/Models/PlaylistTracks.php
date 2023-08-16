<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistTracks extends Model
{
    protected string $table = 'playlist_tracks';

    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function create(int $playlistId, int $trackId): void
    {
        $this->playlist_id = $playlistId;
        $this->track_id = $trackId;

        $this->save();
    }
}
