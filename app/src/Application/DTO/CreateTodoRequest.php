<?php

declare(strict_types=1);

namespace App\Application\DTO;

class CreateTodoRequest
{
    public string $description;
    public bool $is_complete;
}
