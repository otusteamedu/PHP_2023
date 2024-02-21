<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\EventDTO;

interface SearchEventInterface
{
    public function searchBy(array $conditionsDTO): EventDTO;
}
