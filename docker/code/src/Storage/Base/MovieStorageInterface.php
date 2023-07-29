<?php

namespace IilyukDmitryi\App\Storage\Base;


interface MovieStorageInterface
{
    public function add(array $channel):bool;

    public function delete(string $channelId):bool;
    public function update(string $channelId, array $channel):bool;

    public function findById(string $movieId): array;

    public function find(array $filter): array;
    public function import(array $filter): bool;

    public function getLikesDislikesFromChannels(): array;

    public function getTopPopularChannels(int $cntTop): array;

}