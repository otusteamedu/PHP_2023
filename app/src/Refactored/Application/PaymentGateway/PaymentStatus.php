<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\PaymentGateway;

enum PaymentStatus: string
{
    case PENDING = 'pending';

    case SUCCEEDED = 'succeeded';

    case CANCELED = 'canceled';
}
