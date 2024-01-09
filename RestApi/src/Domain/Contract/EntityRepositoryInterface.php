<?php

namespace App\Domain\Contract;

use Doctrine\DBAL\LockMode;

interface EntityRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
}
