<?php

namespace Tests;

use App\Infrastructure\Controllers\SomeController;
use App\Infrastructure\PayService\SomeApiPayServiceInterface;
use App\Infrastructure\Repository\SomeRepositoryInterface;
use App\Infrastructure\Request\Request;
use App\Infrastructure\Request\RequestInterface;
use App\Infrastructure\Response\Response;
use App\Infrastructure\Response\ResponseInterface;
use PHPUnit\Framework\TestCase;
use Tests\PayService\DummyPayServiceNegative;
use Tests\PayService\DummyPayServicePositive;
use Tests\Repository\DummyRepositoryNegative;
use Tests\Repository\DummyRepositoryPositive;

class SomeControllerTest extends TestCase
{
    public static function dataProvider(): array
    {
        $data = [
            "card_number" => "12",
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
            "DataSet1" => [
                new Request(json_encode($data)),
                new DummyRepositoryPositive(),
                new DummyPayServicePositive(),
                new Response(400, "'card_number' is not valid")
            ],
            "DataSet2" => [
                new Request(json_encode($dataValid)),
                new DummyRepositoryPositive(),
                new DummyPayServiceNegative(),
                new Response(403, 'api error')
            ],
            "DataSet3" => [
                new Request(json_encode($dataValid)),
                new DummyRepositoryNegative(),
                new DummyPayServicePositive(),
                new Response(400, 'the amount has not been debited')
            ],
            "DataSet4" => [
                new Request(json_encode($dataValid)),
                new DummyRepositoryPositive(),
                new DummyPayServicePositive(),
                new Response(200, 'the order is paid')
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSomeAction(
        RequestInterface $request,
        SomeRepositoryInterface $repository,
        SomeApiPayServiceInterface $payService,
        ResponseInterface $response
    ) {
        $someController = new SomeController();
        $this->assertEquals($response, $someController->someAction($request, $repository, $payService));
    }
}
