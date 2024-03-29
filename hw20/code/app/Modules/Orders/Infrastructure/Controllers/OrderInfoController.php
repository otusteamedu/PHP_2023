<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\Request\OrderInfoRequest;
use App\Modules\Orders\Application\UseCase\OrderInfoUseCase;
use App\Modules\Orders\Domain\Exception\EntityNotFoundException;
use Illuminate\Http\JsonResponse;

class OrderInfoController extends Controller
{
    public function __construct(
        private OrderInfoUseCase $useCase
    ) {}

    public function run(string $uuid): JsonResponse
    {
        try {
            $orderInfoRequest = new OrderInfoRequest($uuid);
            $result = ($this->useCase)($orderInfoRequest);
            return response()->json($result, 200);
        }
        catch (\Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
