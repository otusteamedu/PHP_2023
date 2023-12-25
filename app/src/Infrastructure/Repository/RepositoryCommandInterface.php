<?php

namespace App\Infrastructure\Repository;

interface RepositoryCommandInterface
{
    public function init(): void;

    public function clearData(): void;
}
