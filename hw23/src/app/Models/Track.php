<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\TrackBuilder;
use App\Decorators\TrackDescriptionDecorator;
use App\Iterators\TracksIterator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected string $table = 'tracks';

    const PER_PAGE = 10;

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
        if ($filter && array_key_exists('genre', $filter)) {
            $tracksListQuery = Track::where('genre', $filter['genre']);

            $tracksList = $tracksListQuery->get();
        } else {
            $tracksList = Track::all();
        }

        if ($filter && array_key_exists('page', $filter)) {
            $currentPage = (int)$filter['page'] === 0 ? 1 : (int)$filter['page'];
            $perPage = array_key_exists('per_page', $filter) ? (int)$filter['per_page'] : self::PER_PAGE;

            $tracksIterator = new TracksIterator($tracksList);
            $tracksList = $tracksIterator->getPaginatedList($currentPage, $perPage);
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
