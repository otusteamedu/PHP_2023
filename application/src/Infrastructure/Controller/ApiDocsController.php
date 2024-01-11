<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure\Controller;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\Service\ApiDocsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiDocsController extends AbstractController
{
    private ApiDocsService $apiDocsService;

    public function __construct(Request $request, ApiDocsService $apiDocsService)
    {
        parent::__construct($request);

        $this->apiDocsService = $apiDocsService;
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function get(): Response
    {
        $response = $this->apiDocsService->get();

        return new JsonResponse($response->content, Response::HTTP_OK);
    }
}
