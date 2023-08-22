<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\DTO\RegisterUserRequest;
use App\Application\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractFOSRestController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Rest\Post("/api/v1/register")
     * @ParamConverter("registerUserRequest", converter="fos_rest.request_body")
     * @param RegisterUserRequest $registerUserRequest
     * @return Response
     */
    public function registerUser(RegisterUserRequest $registerUserRequest): Response
    {
        $response = $this->userService->registerUser($registerUserRequest);
        $view = $this->view($response, 201);
        return $this->handleView($view);
    }
}
