<?php

declare(strict_types=1);

namespace User\Php2023\Domain\Interfaces;

interface Observer {
    public function update(Food $food, int $status): void;
}
