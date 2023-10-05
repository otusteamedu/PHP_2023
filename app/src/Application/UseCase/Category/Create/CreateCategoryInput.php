<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category\Create;

use App\Domain\ValueObject\NotEmptyString;

interface CreateCategoryInput
{
    public function getName(): NotEmptyString;
}
