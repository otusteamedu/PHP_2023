<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\Request\OrderUpdateRequest;
use App\Modules\Orders\Application\UseCase\OrderUpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderUpdateController extends Controller
{
    public function __construct(
        private OrderUpdateUseCase $useCase
    )
    {
        /**
         * @OA\Put(
         *     path="/api/v1/orders/{uuid}",
         *     summary="Update an order by UUID",
         *     description="Update an order with the specified UUID",
         *     tags={"Orders"},
         *     @OA\Parameter(
         *         name="uuid",
         *         in="path",
         *         description="UUID of the order to update",
         *         required=true,
         *         example="123e4567-e89b-12d3-a456-426614174000",
         *         @OA\Schema(type="string")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             @OA\Property(property="email", type="string", example="new_email@example.com"),
         *             @OA\Property(property="comment", type="string", example="Updated comment")
         *         )
         *     ),
         *     @OA\Response(
         *         response="200",
         *         description="Order updated successfully",
         *         @OA\JsonContent(
         *             @OA\Property(property="success", type="boolean", example=true),
         *             @OA\Property(property="message", type="string", example="Order updated successfully")
         *         )
         *     ),
         *     @OA\Response(
         *         response="400",
         *         description="Error updating the order",
         *         @OA\JsonContent(
         *             @OA\Property(property="success", type="boolean", example=false),
         *             @OA\Property(property="message", type="string", example="Error updating the order")
         *         )
         *     )
         * )
         */
    }
    public function run(Request $request, $uuid): JsonResponse
    {
        try{
            $orderUpdateRequest = new OrderUpdateRequest(
                $uuid,
                $request->input('email'),
                $request->input('comment')
            );
            ($this->useCase)($orderUpdateRequest);
            return response()->json(['success' => true, 'message' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }
}
