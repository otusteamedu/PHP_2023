<?php

declare(strict_types=1);

namespace LebedevVR\App\Service;

use LebedevVR\App\DTO\MoviePaymentDTO;

class PaymentService
{
    public function pay(MoviePaymentDTO $cardRequisites): array
    {
        // Request stub
        // $response = curl(https://pay-movie/requisites, $cardRequisites);

        // If odd then success else error
        if ($cardRequisites->getCardNumber() % 2) {
            return ['code' => 200, 'headers' => []];
        } else {
            return ['code' => 400, 'body' => 'Invalid card credentials', 'headers' => []];
        }
    }
}
