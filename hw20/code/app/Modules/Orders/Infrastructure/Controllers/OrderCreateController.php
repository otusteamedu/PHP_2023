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
    {
        /**
         * @OA\Get(
         *     path="/api/data.json",
         *     @OA\Response(
         *         response="200",
         *         description="The data"
         *     )
         * )
         */
    }

    public function run(Request $request): JsonResponse
    {
        try {
            $createOrderRequest = new OrderCreateRequest(
                $request->input('email'),
                $request->input('comment')
            );
            $response = ($this->useCase)($createOrderRequest);
            return response()->json(['success' => true, 'message' => $response->uid], 201);
        }
        catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
