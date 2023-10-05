<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Category;

use App\Application\UseCase\Category\Create\CreateCategoryInput;
use App\Domain\ValueObject\NotEmptyString;

final class ConsoleCreateCategoryInput implements CreateCategoryInput
{
    public function __construct(
        private readonly NotEmptyString $name,
    ) {
    }

    public function getName(): NotEmptyString
    {
        return $this->name;
    }
}
