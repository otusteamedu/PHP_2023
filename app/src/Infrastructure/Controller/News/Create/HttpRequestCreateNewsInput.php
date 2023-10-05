<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\News\Create;

use App\Application\UseCase\News\Create\CreateNewsInput;
use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\HtmlContent;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\NotEmptyString;
use App\Infrastructure\Request\HttpRequest;

final class HttpRequestCreateNewsInput extends HttpRequest implements CreateNewsInput
{
    public function getAuthorId(): Id
    {
        return new Id($this->getRequest()->get('authorId'));
    }

    public function getCategoryId(): Id
    {
        return new Id($this->getRequest()->get('categoryId'));
    }

    public function getContent(): Content
    {
        return new HtmlContent($this->getRequest()->get('content'));
    }

    public function getTitle(): NotEmptyString
    {
        return new NotEmptyString($this->getRequest()->get('title'));
    }
}
