<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Base;

interface EventStorageInterface
{
    public function add(array $arrEvents): int;
    
    public function deleteAll(): int;
    
    public function findTopByParams(array $arrParams): array;
    
    public function list(): array;
}
