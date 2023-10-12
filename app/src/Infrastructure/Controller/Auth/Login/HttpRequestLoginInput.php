<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Auth\Login;

use App\Application\UseCase\User\AuthenticateUserInput;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;
use App\Infrastructure\Request\HttpRequest;

final class HttpRequestLoginInput extends HttpRequest implements AuthenticateUserInput
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
