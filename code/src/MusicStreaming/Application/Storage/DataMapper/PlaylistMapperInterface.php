<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Playlist;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\User;

interface PlaylistMapperInterface
{
    public function findById(int $id): Playlist;
    public function findByName(string $name): Playlist;
    public function findByUser(User $user): array;
    public function insert(Playlist $playlist): void;
    public function update(Playlist $playlist): bool;
    public function delete(Playlist $playlist): bool;
}
