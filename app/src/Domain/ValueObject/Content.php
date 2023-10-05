<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

interface Content
{
    public function getValue(): string;
}
