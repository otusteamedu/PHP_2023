<?php

declare(strict_types=1);

namespace unit\Controller;

use ApiServiceInterface;
use App\Controller\SomeController;
use App\Repository\SomeRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use unit\Repository\DummySomeRepositoryNegative;
use unit\Repository\DummySomeRepositoryPositive;
use unit\Service\DummyPaymentApiServiceNegative;
use unit\Service\DummyPaymentApiServicePositive;

class SomeControllerTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testPayOrder(
        Request                 $request,
        SomeRepositoryInterface $repository,
        ApiServiceInterface     $payService,
        JsonResponse            $response
    ): void {
        $someController = new SomeController();
        $this->assertEquals($response, $someController->payOrder($request, $payService, $repository));
    }

    public static function dataProvider(): array
    {
        $dataInvalid = [
            "card_holder" => "Test Test",
            "card_expiration" => "10/25",
            "cvv" => "123",
            "order_number" => "213",
            "sum" => "10"
        ];

        $dataValid = [
            "card_number" => "1111111111111111",
            "card_holder" => "Test Test",
            "card_expiration" => "10/25",
            "cvv" => "123",
            "order_number" => "213",
            "sum" => "10"
        ];

        return [
            'dateset 1' => [
                new Request($dataInvalid),
                new DummySomeRepositoryPositive(),
                new DummyPaymentApiServicePositive(),
                new JsonResponse(json_encode
                (
                    [
                        'status' => 400,
                        'error' => 'Data no valid',
                    ]
                ), 400)
            ],
            'dateset 2' => [
                new Request($dataValid),
                new DummySomeRepositoryPositive(),
                new DummyPaymentApiServiceNegative(),
                new JsonResponse(json_encode
                (
                    [
                        'status' => 403,
                        'error' => 'api error',
                    ]

                ), 403)
            ],
            'dateset 3' => [
                new Request($dataValid),
                new DummySomeRepositoryNegative(),
                new DummyPaymentApiServicePositive(),
                new JsonResponse(json_encode
                (
                    [
                        'status' => 400,
                        'error' => 'sum has not been debited',
                    ]
                ), 400)
            ],
            'dateset 4' => [
                new Request($dataValid),
                new DummySomeRepositoryPositive(),
                new DummyPaymentApiServicePositive(),
                new JsonResponse(json_encode
                (
                    [
                        'status' => 200,
                        'message' => 'order is paid',
                    ]
                ), 200)
            ],
        ];
    }
}
