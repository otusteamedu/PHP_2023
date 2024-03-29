<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\Request\OrderCreateRequest;
use App\Modules\Orders\Application\UseCase\OrderCreateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderCreateController extends Controller
{
    public function __construct(
        private OrderCreateUseCase $useCase
    )
    {}

    public function run(Request $request): JsonResponse
    {
        try {
            $createOrderRequest = new OrderCreateRequest(
                $request->input('email'),
                $request->input('comment')
            );
            $response = ($this->useCase)($createOrderRequest);
            return response()->json(['message' => $response->uid], 201);
        }
        catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
