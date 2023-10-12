<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Domain\ValueObject\Id;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UserHttpRequest
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Security $security,
    ) {
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function getCurrentUserId(): Id
    {
        return new Id($this->security->getUser()->getUserIdentifier());
    }
}
