<?php

namespace App\Application\Dto;

readonly class RequestDto
{
    public function __construct(private string $id, private string $status)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
