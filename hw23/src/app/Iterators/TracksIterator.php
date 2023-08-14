<?php

namespace App\Iterators;

use ArrayIterator;
use Illuminate\Database\Eloquent\Collection;
use IteratorAggregate;

class TracksIterator implements IteratorAggregate
{
    private Collection $tracks;

    public function __construct($tracks)
    {
        $this->tracks = $tracks;
    }

    public function getPaginatedList(int $currentPage, int $perPage): Collection
    {
        $resultList = new Collection();
        $key = 0;
        $startKey = ($currentPage - 1) * $perPage;
        $maxKey = $currentPage * $perPage;

        foreach ($this->tracks as $track) {
            if (count($resultList) < $perPage && $key >= $startKey && $key < $maxKey) {
                $resultList->add($track);
            }

            $key++;
        }

        return $resultList;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->tracks);
    }
}
