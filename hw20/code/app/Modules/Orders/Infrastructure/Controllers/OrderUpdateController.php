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
    {}

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
