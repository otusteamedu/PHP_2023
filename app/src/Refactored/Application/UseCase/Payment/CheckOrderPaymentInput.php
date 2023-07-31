<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\UseCase\Payment;

use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;

interface CheckOrderPaymentInput
{
    public function getPaymentId(): Id;
}
