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
    ) {}

    /**
     * @OA\Post(
     *     path="/api/v1/orders",
     *     summary="Create a new order",
     *     description="Create a new order with email and comment",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="example@example.com"),
     *             @OA\Property(property="comment", type="string", example="Sample comment")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Order created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Order created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid input data",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid input data")
     *         )
     *     )
     * )
     */
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
