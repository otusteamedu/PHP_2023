<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\News\Read;

use App\Application\UseCase\News\Read\ReadNewsInput;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Request\HttpRequest;

final class HttpRequestReadNewsInput extends HttpRequest implements ReadNewsInput
{
    public function getId(): Id
    {
        return new Id($this->getRequest()->get('news_id'));
    }
}
