<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\PlaylistFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Playlist
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection<int, Track> $tracks
 * @property-read int|null $tracks_count
 * @method static PlaylistFactory factory($count = null, $state = [])
 * @method static Builder|Playlist newModelQuery()
 * @method static Builder|Playlist newQuery()
 * @method static Builder|Playlist query()
 * @method static Builder|Playlist whereCreatedAt($value)
 * @method static Builder|Playlist whereId($value)
 * @method static Builder|Playlist whereName($value)
 * @method static Builder|Playlist whereUpdatedAt($value)
 * @method static Builder|Playlist whereUserId($value)
 * @mixin Eloquent
 */
class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name'
    ];

    public function tracks()
    {
        return $this->belongsToMany(
            Track::class,
            'tracks_playlists',
            'playlists_id',
            'tracks_id'
        )->using(PlaylistsTracks::class);
    }
}
