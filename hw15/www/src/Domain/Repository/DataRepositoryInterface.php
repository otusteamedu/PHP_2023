<?php

namespace Shabanov\Otusphp\Domain\Repository;

interface DataRepositoryInterface
{
    public function findAll(array $arRequest): ?array;
}
