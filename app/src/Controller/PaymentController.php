<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\MoviePaymentDTO;
use App\Repository\PaymentRepository;
use App\Service\PaymentService;
use App\Validator\MoviePaymentValidator;

class PaymentController
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly PaymentRepository $paymentRepository
    ) {
    }

    public function moviePaymentAction(MoviePaymentDTO $request): void
    {
        $validator = new MoviePaymentValidator();
        $validator->validate($request);

        if ($this->paymentService->pay($request)['code'] === 200) {
            $this->paymentRepository->add([
                'id' => 1,
                'order_number' => $request->getOrderNumber(),
                'card_holder' => $request->getCardHolder(),
                'sum' => $request->getSum()
            ]);
            header('HTTP/1.0 200 Ok');
            echo 'Successful payment';
        } else {
            header('HTTP/1.0 403 Forbidden');
            echo 'Unsuccessful payment';
        }
    }
}