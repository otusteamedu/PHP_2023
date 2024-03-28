<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\Request\OrderInfoRequest;
use App\Modules\Orders\Application\UseCase\OrderInfoUseCase;
use Illuminate\Http\Request;

class OrderInfoController extends Controller
{
    public function __construct(
      //  private OrderInfoUseCase $useCase
    )
    {}

    public function run(string $uuid)
    {
        dd($uuid);
        $orderInfoRequest = new OrderInfoRequest($request->get('uuid'));
        $result = ($this->useCase)($orderInfoRequest);
        dd(1, $result);
        return response()->json(['message' => 'Orders info'], 200);
    }
}
