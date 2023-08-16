<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Domain\Model\EventModel;
use IilyukDmitryi\App\Domain\ValueObject\Params;

interface EventRepositoryInterface
{
    public function add(EventModel $eventModel): int;
    
    public function deleteAll(): int;
    
    public function findTopByParams(Params $params): ?EventModel;
    
    public function list(): array;
}
