<?php

namespace Common\Infrastructure;

use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;
use Sunrise\Http\Message\Response\JsonResponse;

class Controller
{
    public function __construct()
    {
    }

    /**
     * @OA\Get(
     *     path="/",
     *     operationId="index",
     *     @OA\Response(
     *         response="200",
     *         description="Main page"
     *     )
     * )
     */
    public function index(): ResponseInterface
    {
        return new JsonResponse(200, ['hello' => 'world']);
    }
}