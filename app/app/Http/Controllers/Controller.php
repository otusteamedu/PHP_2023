<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

class Controller extends BaseController
{
    public const STATUS_MESSAGE_404 = 'not found';
    public const STATUS_404 = 404;
    /**
     * @OA\Info(
     *   title="Example API",
     *   version="1.0",
     *   @OA\Contact(
     *     email="support@example.com",
     *     name="Support Team"
     *   )
     * )
     */

    protected function errorResponse(string $message = '', int $code = 400, array $errors = null): JsonResponse
    {
        return response()->json([
            'errors' => $errors,
            'data' => null,
            'message' => $message,
            'status' => 'error'
        ], $code);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse(array $data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'errors' => null,
            'data' => $data,
            'message' => $message,
            'status' => 'success'
        ], $code);
    }
}
