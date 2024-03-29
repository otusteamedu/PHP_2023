<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\UseCase\OrdersListUseCase;
use Illuminate\Http\JsonResponse;

class OrderListController extends Controller
{
    public function __construct(
        private OrdersListUseCase $useCase
    )
    {}

    public function run(): JsonResponse
    {
        try {
            $orders = ($this->useCase)();
            return response()->json($orders, 200);
        } catch (\Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
