<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\UseCase\Payment;

use Imitronov\Hw15\Refactored\Domain\ValueObject\Email;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;

interface RegisterOrderPaymentInput
{
    public function getOrderId(): Id;

    public function getClientEmail(): Email;
}
