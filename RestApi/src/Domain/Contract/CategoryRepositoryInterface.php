<?php

namespace App\Domain\Contract;

interface CategoryRepositoryInterface
{
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}