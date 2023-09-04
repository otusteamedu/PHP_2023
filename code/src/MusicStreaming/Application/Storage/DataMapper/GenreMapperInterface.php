<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Genre;

interface GenreMapperInterface
{
    public function findById(int $id): Genre;
    public function findByName(string $name): Genre;
    public function insert(Genre $genre): void;
    public function update(Genre $genre): bool;
    public function delete(Genre $genre): bool;
}
