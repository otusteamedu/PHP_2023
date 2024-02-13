<?php

declare(strict_types=1);

namespace src\Queue\Domain\Repository;

use src\Queue\Domain\Entity\Element;

interface ElementRepositoryInterface
{
    public function get(string $uuid): ?Element;

    public function add(Element $element): void;

    public function delete(string $uuid): void;

    public function readAll(): array;
}
