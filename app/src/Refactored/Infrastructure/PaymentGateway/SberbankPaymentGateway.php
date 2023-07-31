<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Infrastructure\PaymentGateway;

use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentGatewayException;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentGatewayInterface;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\PaymentStatus;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\RegisterPaymentDto;
use Imitronov\Hw15\Refactored\Application\PaymentGateway\RegisterPaymentResultDto;
use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Url;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SberbankPaymentGateway implements PaymentGatewayInterface
{
    const PRODUCTION_URL = 'https://securepayments.sberbank.ru/payment/rest/';

    const DEVELOPMENT_URL = 'https://3dsec.sberbank.ru/payment/rest/';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $merchantUserName,
        private readonly string $merchantPassword,
        private readonly bool $isProduction,
    ) {
    }

    /**
     * @link https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:register
     * @throws InvalidArgumentException
     * @throws PaymentGatewayException
     */
    public function registerPayment(RegisterPaymentDto $dto): RegisterPaymentResultDto
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->getUrl('register.do'),
                [
                    'body' => [
                        'userName' => $this->merchantUserName,
                        'password' => $this->merchantPassword,
                        'orderNumber' => $dto->paymentId,
                        'amount' => $dto->amount->getAmountInCents(),
                        'currency' => $dto->amount->getCurrencyCode()->value,
                        'returnUrl' => $dto->returnUrl,
                        'failUrl' => $dto->failUrl,
                        'description' => $dto->description,
                        'email' => $dto->clientEmail,
                        'phone' => $dto->clientPhone,
                    ],
                ]
            );
            $content = $response->toArray();
        } catch (
            ClientExceptionInterface
            | DecodingExceptionInterface
            | RedirectionExceptionInterface
            | ServerExceptionInterface
            | TransportExceptionInterface $exception
        ) {
            throw new PaymentGatewayException(
                'Не удалось зарегистрировать платеж в платежной системе.',
                100,
                $exception,
            );
        }

        return new RegisterPaymentResultDto(
            new Id($content['orderId']),
            new Url($content['formUrl']),
        );
    }

    /**
     * @link https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:getorderstatusextended
     * @inheritdoc
     */
    public function getStatusByPaymentId(Id $paymentId): PaymentStatus
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->getUrl('getOrderStatusExtended.do'),
                [
                    'query' => [
                        'userName' => $this->merchantUserName,
                        'password' => $this->merchantPassword,
                        'paymentId' => $paymentId,
                    ],
                ]
            );
            $content = $response->toArray();
        } catch (
            ClientExceptionInterface
            | DecodingExceptionInterface
            | RedirectionExceptionInterface
            | ServerExceptionInterface
            | TransportExceptionInterface $exception
        ) {
            throw new PaymentGatewayException(
                'Не удалось проверить статус платежа в платежной системе.',
                101,
                $exception,
            );
        }

        return match ($content['orderStatus']) {
            0, 1, 5 => PaymentStatus::PENDING,
            2 => PaymentStatus::SUCCEEDED,
            3, 4, 6 => PaymentStatus::CANCELED,
            default => throw new InvalidArgumentException(sprintf('Unknown status "%s".', $content['orderStatus'])),
        };
    }

    private function getUrl(string $action): string
    {
        return sprintf(
            '%s%s',
            $this->isProduction ? self::PRODUCTION_URL : self::DEVELOPMENT_URL,
            $action,
        );
    }
}
