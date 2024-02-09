<?php

namespace App\Domain\Contract;

interface EventRepositoryInterface
{
    public function getAllEvents(): array;
}