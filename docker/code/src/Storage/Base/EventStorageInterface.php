<?php

namespace IilyukDmitryi\App\Storage\Base;

interface EventStorageInterface
{
    public function add(array $arrEvents): int;
    
    public function deleteAll(): int;
    
    public function findTopByParams(array $arrParams): array;
    
    public function list(): array;
}
