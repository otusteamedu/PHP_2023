<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\UseCase\OrdersListUseCase;

class OrderListController extends Controller
{
    public function __construct(
        private OrdersListUseCase $useCase
    )
    {}

    public function run()
    {
        $orders = ($this->useCase)();
        return response()->json($orders, 200);
    }
}
