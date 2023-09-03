<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Track;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Genre;

interface TrackMapperInterface
{
    public function findById(int $id): Track;
    public function findByGenre(Genre $genre, $limit, $offset): array;
    public function insert(Track $track): void;
    public function update(Track $track): bool;
    public function delete(Track $track): bool;
}
