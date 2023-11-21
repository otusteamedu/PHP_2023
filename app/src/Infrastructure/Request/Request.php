<?php

namespace App\Infrastructure\Request;

use App\Infrastructure\Exception\CardExpirationException;
use App\Infrastructure\Exception\CardHolderException;
use App\Infrastructure\Exception\CardNumberException;
use App\Infrastructure\Exception\CvvException;
use App\Infrastructure\Exception\OrderNumberException;
use App\Infrastructure\Exception\SumException;
use Exception;

class Request implements RequestInterface
{
    private string $requestJson;

    public function __construct(string $requestJson)
    {
        $this->requestJson = $requestJson;
    }

    public function toArray(): array
    {
        return json_decode($this->requestJson, true);
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        $data = $this->toArray();
        $cardNumber = $data['card_number'] ?? null;
        $cardHolder = $data['card_holder'] ?? null;
        $cardExpiration = $data['card_expiration'] ?? null;
        $cvv = $data['cvv'] ?? null;
        $orderNumber = $data['order_number'] ?? null;
        $sum = $data['sum'] ?? null;

        if (
            is_null($cardNumber)
            || preg_match('/^[0-9]{16}$/', $cardNumber) != 1
        ) {
            throw new CardNumberException("'card_number' is not valid");
        }

        if (
            is_null($cardHolder)
            || preg_match('/^[A-Za-z -]+$/', $cardHolder) != 1
        ) {
            throw new CardHolderException("'card_holder' is not valid");
        }

        if (
            is_null($cardExpiration)
            || preg_match('/^[0-9]{2}\/[0-9]{2}$/', $cardExpiration) != 1
        ) {
            throw new CardExpirationException("'card_expiration' is not valid");
        }

        if (
            is_null($cvv)
            || preg_match('/^[0-9]{3}$/', $cvv) != 1
        ) {
            throw new CvvException("'cvv' is not valid");
        }

        if (
            is_null($orderNumber)
            || preg_match('/^[0-9]{1,16}$/', $orderNumber) != 1
        ) {
            throw new OrderNumberException("'order_number' is not valid");
        }

        if (
            is_null($sum)
            || preg_match('/^[0-9]*,?[0-9]{2,}$/', $sum) != 1
        ) {
            throw new SumException("'sum' is not valid");
        }
    }
}
