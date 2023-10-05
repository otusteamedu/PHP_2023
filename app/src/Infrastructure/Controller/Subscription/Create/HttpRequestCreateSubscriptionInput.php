<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Subscription\Create;

use App\Application\UseCase\Subscription\CreateSubscriptionInput;
use App\Domain\ValueObject\Id;
use App\Infrastructure\Request\HttpRequest;

final class HttpRequestCreateSubscriptionInput extends HttpRequest implements CreateSubscriptionInput
{
    public function getCategoryId(): Id
    {
        return new Id($this->getRequest()->get('categoryId'));
    }

    public function getUserId(): Id
    {
        return new Id($this->getRequest()->get('userId'));
    }
}
