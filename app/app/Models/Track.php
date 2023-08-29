<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\TrackFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Track
 *
 * @property int $id
 * @property string $name
 * @property string $author
 * @property int $genre_id
 * @property int $duration
 * @property string $file
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static TrackFactory factory($count = null, $state = [])
 * @method static Builder|Track newModelQuery()
 * @method static Builder|Track newQuery()
 * @method static Builder|Track query()
 * @method static Builder|Track whereAuthor($value)
 * @method static Builder|Track whereCreatedAt($value)
 * @method static Builder|Track whereDuration($value)
 * @method static Builder|Track whereFile($value)
 * @method static Builder|Track whereGenreId($value)
 * @method static Builder|Track whereId($value)
 * @method static Builder|Track whereName($value)
 * @method static Builder|Track whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
        'genre_id',
        'duration',
        'file',
    ];

    public function playLists()
    {
        return $this->belongsToMany(
            Track::class,
            'tracks_playlists',
            'tracks_id',
            'playlists_id'
        )->using(PlaylistsTracks::class);
    }

}
