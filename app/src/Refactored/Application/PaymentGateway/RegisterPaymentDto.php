<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\PaymentGateway;

use Imitronov\Hw15\Refactored\Domain\ValueObject\Email;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Money;
use Imitronov\Hw15\Refactored\Domain\ValueObject\NotEmptyString;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Phone;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Url;

final class RegisterPaymentDto
{
    public function __construct(
        public readonly Id $paymentId,
        public readonly Money $amount,
        public readonly Url $returnUrl,
        public readonly Url $failUrl,
        public readonly NotEmptyString $description,
        public readonly Email $clientEmail,
        public readonly Phone $clientPhone,
    ) {
    }
}
