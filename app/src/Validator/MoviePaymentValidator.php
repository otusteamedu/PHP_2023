<?php

declare(strict_types=1);

namespace LebedevVR\App\Validator;

use LebedevVR\App\DTO\MoviePaymentDTO;
use LebedevVR\App\Exception\CardExpirationValidationException;
use LebedevVR\App\Exception\CardHolderValidationException;
use LebedevVR\App\Exception\CardNumberValidationException;
use LebedevVR\App\Exception\CvvValidationException;
use LebedevVR\App\Exception\OrderNumberValidationException;
use LebedevVR\App\Exception\SumValidationException;

class MoviePaymentValidator
{
    public function validate(MoviePaymentDTO $dto): void
    {
        if (strlen((string)$dto->getCardNumber()) !== 16) {
            throw new CardNumberValidationException('Card number must contain 16 digits');
        }
        if (!preg_match('/^\d+$/', (string)$dto->getCardNumber())) {
            throw new CardNumberValidationException('Card number must contain only digits');
        }

        $nameSurname = explode(' ', $dto->getCardHolder());
        if (count($nameSurname) !== 2) {
            throw new CardHolderValidationException('Card holder must contain 2 words: Name Surname');
        }
        if (!preg_match('/^[A-Z][-a-z]+[a-z]$/', $nameSurname[0])) {
            throw new CardHolderValidationException('Name in Card Holder must begin with uppercase letter and then contain lowercase letters or symbol "-"');
        }
        if (!preg_match('/^[A-Z][-a-z]+[a-z]$/', $nameSurname[1])) {
            throw new CardHolderValidationException('Surname in Card Holder must begin with uppercase letter and then contain lowercase letters or symbol "-"');
        }

        if (!preg_match('/^\d{2}\/\d{2}$/', $dto->getCardExpiration())) {
            throw new CardExpirationValidationException('Date format in Card Expiration field must be "mm/yy"');
        }
        $timestamp = strtotime('01/' . $dto->getCardExpiration());
        if ($timestamp < time()) {
            throw new CardExpirationValidationException('Your card has been expired');
        }

        if (!preg_match('/^\d{3}$/', (string)$dto->getCvv())) {
            throw new CvvValidationException('Cvv must contain only 3 digits');
        }

        if (strlen($dto->getOrderNumber()) > 16 || strlen($dto->getOrderNumber()) < 12) {
            throw new OrderNumberValidationException('Order number must contain more then 11 symbols but less then 17 one');
        }

        if (!preg_match('/^\d+(,\d{1,2})?$/', $dto->getSum())) {
            throw new SumValidationException('Sum must be in format "xxx" or "xxx,xx" where "x" is a digit');
        }
    }
}
