<?php

namespace App\Application\action;

interface SearchInterface
{
    public function search(CriteriaInterface $criteria): array;
}
