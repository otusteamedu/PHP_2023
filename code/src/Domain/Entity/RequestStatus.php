<?php

declare(strict_types=1);

namespace Art\Code\Domain\Entity;

class RequestStatus
{
    private int $id;
    private string $name;

    const REQUEST_STATUS_INIT = 1;
    const REQUEST_STATUS_IN_PROCESS = 2;
    const REQUEST_STATUS_COMPLETED = 3;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}