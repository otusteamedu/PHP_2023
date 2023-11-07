<?php

declare(strict_types=1);

namespace Gesparo\ES\Search;

use Gesparo\ES\AppException;

class Title
{
    private string $title;

    /**
     * @throws AppException
     */
    public function __construct(string $title)
    {
        $this->title = $title;
        $this->assertTitle();
    }

    public function get(): string
    {
        return $this->title;
    }

    /**
     * @throws AppException
     */
    private function assertTitle(): void
    {
        if (empty($this->title)) {
            throw AppException::titleCannotBeEmpty();
        }
    }
}
