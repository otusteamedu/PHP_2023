<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\Request\OrderDeleteRequest;
use App\Modules\Orders\Application\UseCase\OrderDeleteUseCase;
use Illuminate\Http\JsonResponse;

class OrderDeleteController extends Controller
{
    public function __construct(
        private OrderDeleteUseCase $useCase
    )
    {}

    public function run(string $uuid): JsonResponse
    {
        $orderDeleteRequest = new OrderDeleteRequest($uuid);
        ($this->useCase)($orderDeleteRequest);

        return response()->json(null, 204);
    }
}
