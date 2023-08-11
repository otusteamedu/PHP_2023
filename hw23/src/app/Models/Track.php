<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\TrackBuilder;
use App\Decorators\TrackDescriptionDecorator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected string $table = 'tracks';

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }

    public function create(array $data): array|int
    {
        $trackBuilder = new TrackBuilder();
        $result = $trackBuilder->build($data);

        if ($result instanceof Track) {
            $result->save();

            return $result->id;
        }

        return $result;
    }

    public function getList(array $filter = []): Collection
    {
        if ($filter) {
            $tracksListQuery = Track::where('title', '<>', '');

            if (array_key_exists('genre', $filter)) {
                $tracksListQuery = $tracksListQuery->where('genre', $filter['genre']);
            }

            $tracksList = $tracksListQuery->get();
        } else {
            $tracksList = Track::all();
        }

        $this->decorateDescription($tracksList);

        return $tracksList;
    }

    private function decorateDescription(&$tracksList): void
    {
        foreach ($tracksList as $key => $value) {
            $descriptionDecorator = new TrackDescriptionDecorator($value, $value['description']);
            $tracksList[$key]['description'] = $descriptionDecorator->decorate();
        }
    }
}
