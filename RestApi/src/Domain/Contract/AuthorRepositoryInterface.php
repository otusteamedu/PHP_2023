<?php

namespace App\Domain\Contract;

interface AuthorRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
}
