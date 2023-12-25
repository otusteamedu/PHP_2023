<?php

namespace App\Infrastructure\Repository;

interface RepositoryInterface extends
    RepositoryValidateInterface,
    RepositoryQueryInterface,
    RepositoryCommandInterface
{
}
