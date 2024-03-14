<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Domain\Repository;

use AYamaliev\hw11\Application\Dto\SearchDto;

interface BookRepositoryInterface
{
    public function search(SearchDto $searchDto);
}
