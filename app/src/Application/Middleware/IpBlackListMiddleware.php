<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\Exception\ForbiddenException;

final class IpBlackListMiddleware extends Middleware
{
    public function __construct(
        private readonly array $blackListIpAddresses,
    ) {
    }

    /**
     * @throws ForbiddenException
     */
    public function handle(RequestInterface $request): ?RequestInterface
    {
        if (in_array($request->getClientIp(), $this->blackListIpAddresses)) {
            throw new ForbiddenException('Your ip in black list!');
        }

        return parent::handle($request);
    }
}
