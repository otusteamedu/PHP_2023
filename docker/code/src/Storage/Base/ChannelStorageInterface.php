<?php

namespace IilyukDmitryi\App\Storage\Base;


interface ChannelStorageInterface
{
    public function add(array $channel):bool;
    public function delete(string $channelId):bool;
    public function update(string $channelId, array $channel):bool;
    public function findById(string $channelId): array;

    public function find(array $filter): array;

    public function import(array $arrElements,bool $clearStorage = false): bool;
}
