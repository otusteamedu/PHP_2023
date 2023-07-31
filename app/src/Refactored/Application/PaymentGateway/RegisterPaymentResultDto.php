<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\PaymentGateway;

use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Url;

final class RegisterPaymentResultDto
{
    public function __construct(
        public readonly Id $id,
        public readonly Url $url,
    ) {
    }
}
