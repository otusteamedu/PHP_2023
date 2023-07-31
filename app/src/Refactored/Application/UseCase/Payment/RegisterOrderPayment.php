<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Application\UseCase\Payment;

use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentGatewayException;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentGatewayInterface;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\RegisterPaymentDto;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\RegisterPaymentResultDto;
use Imitronov\Hw15\Refactored\Domain\Constant\PaymentStatus;
use Imitronov\Hw15\Refactored\Domain\Entity\Payment;
use Imitronov\Hw15\Refactored\Domain\Exception\EntityNotFoundException;
use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;
use Imitronov\Hw15\Refactored\Domain\Repository\Flusher;
use Imitronov\Hw15\Refactored\Domain\Repository\OrderRepository;
use Imitronov\Hw15\Refactored\Domain\Repository\PaymentRepository;
use Imitronov\Hw15\Refactored\Domain\Repository\Persister;
use Imitronov\Hw15\Refactored\Domain\ValueObject\NotEmptyString;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Url;

final class RegisterOrderPayment
{
    private readonly Url $returnUrl;

    private readonly Url $failUrl;

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly PaymentGatewayInterface $paymentGateway,
        private readonly PaymentRepository $paymentRepository,
        private readonly Persister $persister,
        private readonly Flusher $flusher,
        string $returnUrl,
        string $failUrl,
    ) {
        $this->returnUrl = new Url($returnUrl);
        $this->failUrl = new Url($failUrl);
    }

    /**
     * @throws InvalidArgumentException
     * @throws EntityNotFoundException
     * @throws PaymentGatewayException
     */
    public function handle(RegisterOrderPaymentInput $input): RegisterPaymentResultDto
    {
        $order = $this->orderRepository->firstOrFailById($input->getOrderId());
        $payment = new Payment(
            $this->paymentRepository->nextId(),
            $order,
            $order->getAmount(),
            null,
            PaymentStatus::PENDING,
        );
        $result = $this->paymentGateway->registerPayment(
            new RegisterPaymentDto(
                $payment->getId(),
                $payment->getAmount(),
                $this->returnUrl,
                $this->failUrl,
                new NotEmptyString(sprintf('Оплата по бронированию №%s', $order->getId()->getValue())),
                $input->getClientEmail(),
                $order->getClient()->getPhone(),
            ),
        );
        $payment->setTransactionId($result->id);
        $this->persister->persist($payment);
        $this->flusher->flush();

        return $result;
    }
}
