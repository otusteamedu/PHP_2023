<?php

declare(strict_types=1);

namespace LebedevVR\App\Controller;

use LebedevVR\App\DTO\MoviePaymentDTO;
use LebedevVR\App\Repository\PaymentRepository;
use LebedevVR\App\Service\PaymentService;
use LebedevVR\App\Validator\MoviePaymentValidator;

class PaymentController
{
    public function __construct(
        private readonly PaymentService    $paymentService,
        private readonly PaymentRepository $repository){

    }

    public function moviePaymentAction(MoviePaymentDTO $request): void
    {
        $validator = new MoviePaymentValidator();
        $validator->validate($request);

        if ($this->paymentService->pay($request)['code'] === 200) {
            $this->repository->add([
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
