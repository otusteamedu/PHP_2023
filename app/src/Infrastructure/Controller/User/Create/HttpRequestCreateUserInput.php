<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\User\Create;

use App\Application\UseCase\User\CreateUserInput;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;
use App\Infrastructure\Request\HttpRequest;

final class HttpRequestCreateUserInput extends HttpRequest implements CreateUserInput
{
    public function getEmail(): Email
    {
        return new Email($this->getRequest()->get('email'));
    }

    public function getPassword(): NotEmptyString
    {
        return new NotEmptyString($this->getRequest()->get('password'));
    }
}
