<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\Create;

use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\NotEmptyString;

interface CreateNewsInput
{
    public function getCategoryId(): Id;

    public function getAuthorId(): Id;

    public function getTitle(): NotEmptyString;

    public function getContent(): Content;
}
