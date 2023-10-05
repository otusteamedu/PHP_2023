<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\Read;

use App\Domain\ValueObject\Id;

interface ReadNewsInput
{
    public function getId(): Id;
}
