<?php

declare(strict_types=1);

namespace AYamaliev\hw12\Application\Repository;

use AYamaliev\hw12\Application\Dto\SearchDto;
use AYamaliev\hw12\Domain\Entity\Event;

interface RepositoryInterface
{
    public function add(Event $event): void;

    public function get(SearchDto $searchDto): ?Event;

    public function clear(): void;
}
