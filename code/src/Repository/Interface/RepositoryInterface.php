<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic\Repository\Interface;

use Timerkhanov\Elastic\Exception\EmptySearchQueryException;
use Timerkhanov\Elastic\Exception\FileNotFoundException;
use Timerkhanov\Elastic\Exception\RepositoryException;
use Timerkhanov\Elastic\QueryBuilder\SearchQueryBuilder;

interface RepositoryInterface
{
    /**
     * @throws FileNotFoundException
     * @throws RepositoryException
     */
    public function load(string $path): void;

    /**
     * @throws EmptySearchQueryException
     * @throws RepositoryException
     */
    public function search(SearchQueryBuilder $queryBuilder): array;
}
