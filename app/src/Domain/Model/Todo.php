<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\TodoDescription;

class Todo
{
    private int $id;
    private TodoDescription $description;
    private bool $is_complete;

    public function __construct(TodoDescription $description, bool $is_complete = false)
    {
        $this->description = $description;
        $this->is_complete = $is_complete;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return TodoDescription
     */
    public function getDescription(): TodoDescription
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isIsComplete(): bool
    {
        return $this->is_complete;
    }
}
