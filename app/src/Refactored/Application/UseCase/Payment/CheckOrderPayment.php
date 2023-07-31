<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\UseCase\Payment;

use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentGatewayException;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentGatewayInterface;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentStatus;
use Imitronov\Hw15\Refactored\Domain\Constant\PaymentStatus as DomainPaymentStatus;
use Imitronov\Hw15\Refactored\Domain\Entity\Payment;
use Imitronov\Hw15\Refactored\Domain\Exception\EntityNotFoundException;
use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;
use Imitronov\Hw15\Refactored\Domain\Repository\Flusher;
use Imitronov\Hw15\Refactored\Domain\Repository\PaymentRepository;

final class CheckOrderPayment
{
    public function __construct(
        private readonly PaymentRepository $paymentRepository,
        private readonly PaymentGatewayInterface $paymentGateway,
        private readonly Flusher $flusher,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws EntityNotFoundException
     * @throws PaymentGatewayException
     */
    public function handle(CheckOrderPaymentInput $input): Payment
    {
        $payment = $this->paymentRepository->firstOrFailById($input->getPaymentId());
        $status = $this->paymentGateway->getStatusByPaymentId($payment->getTransactionId());
        $payment->setStatus(
            match ($status) {
                PaymentStatus::CANCELED => DomainPaymentStatus::CANCELED,
                PaymentStatus::SUCCEEDED => DomainPaymentStatus::SUCCEEDED,
                PaymentStatus::PENDING => DomainPaymentStatus::PENDING,
                default => throw new InvalidArgumentException(sprintf('Unknown payment status "%s".', $status->value)),
            }
        );
        $this->flusher->flush();

        return $payment;
    }
}
