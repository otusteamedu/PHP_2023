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

    /**
     * @OA\Delete(
     *     path="/api/v1/orders/{uuid}",
     *     summary="Delete an order by UUID",
     *     description="Delete an order using its UUID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the order to delete",
     *         required=true,
     *         example="123e4567-e89b-12d3-a456-426614174000",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Order deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Order deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Order not found or unable to delete",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Order not found or unable to delete")
     *         )
     *     )
     * )
     */
    public function run(string $uuid): JsonResponse
    {
        try {
            $orderDeleteRequest = new OrderDeleteRequest($uuid);
            ($this->useCase)($orderDeleteRequest);
            return response()->json(['success' => true, 'message' => 'ok'], 200);
        } catch (\Throwable $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 200);
        }
    }
}
