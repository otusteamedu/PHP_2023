<?php

namespace App\Infrastructure\Repository;

interface RepositoryValidateInterface
{
    public function isDataValid(): bool;
}
