<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;
use App\Modules\Orders\Application\Request\OrderInfoRequest;
use App\Modules\Orders\Application\UseCase\OrderInfoUseCase;
use Illuminate\Http\JsonResponse;

class OrderInfoController extends Controller
{
    public function __construct(
        private OrderInfoUseCase $useCase
    ) {}


    /**
     * @OA\Get(
     *     path="/api/v1/orders/{uuid}",
     *     summary="Get information about a specific order",
     *     description="Retrieve information about an order by its UUID",
    tags={"Orders"},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the order to retrieve information about",
     *         required=true,
     *         example="123e4567-e89b-12d3-a456-426614174000",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error occurred",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error occurred while retrieving order information")
     *         )
     *     )
     * )
     */

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
