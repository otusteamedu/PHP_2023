<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\PaymentGateway;

use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;

interface PaymentGatewayInterface
{
    /**
     * @throws InvalidArgumentException
     * @throws PaymentGatewayException
     */
    public function registerPayment(RegisterPaymentDto $dto): RegisterPaymentResultDto;

    /**
     * @throws InvalidArgumentException
     * @throws PaymentGatewayException
     */
    public function getStatusByPaymentId(Id $paymentId): PaymentStatus;
}
