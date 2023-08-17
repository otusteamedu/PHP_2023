<?php

declare(strict_types=1);

namespace Art\Code\Application\Contract;

use Art\Code\Domain\Model\Response;

interface PostInterface
{
    public function process(): Response;
    public function addEvent(): bool;
    public function findEvent(): mixed;
}
