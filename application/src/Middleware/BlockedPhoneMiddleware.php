<?php

declare(strict_types=1);

namespace Gesparo\HW\Middleware;

use Gesparo\HW\App\AppException;
use Symfony\Component\HttpFoundation\Request;

class BlockedPhoneMiddleware extends BaseMiddleware
{
    private const BLOCKED_PHONES = [
        '+77777777777',
        '+78888888888',
        '+79999999999',
    ];

    /**
     * @throws AppException
     */
    public function handle(Request $request)
    {
        if ($request->get('phone') !== null) {
            $phone = $request->get('phone');

            if (in_array($phone, self::BLOCKED_PHONES, true)) {
                throw AppException::phoneIsBlocked($phone);
            }
        }

        return parent::handle($request);
    }
}
