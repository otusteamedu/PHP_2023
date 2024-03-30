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
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/orders/",
     *     summary="Get all orders",
     *     description="Retrieve a list of all orders",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response="200",
     *         description="List of orders retrieved successfully",
     *         @OA\JsonContent(
     *             type="json",
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error retrieving orders",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error retrieving orders")
     *         )
     *     )
     * )
     */
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
