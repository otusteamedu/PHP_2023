<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\DTO\CreateTodoRequest;
use App\Application\Service\TodoService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends AbstractFOSRestController
{
    private TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * @Rest\Post("/api/v1/todo")
     * @ParamConverter("createTodoRequest", converter="fos_rest.request_body")
     * @param CreateTodoRequest $createTodoRequest
     * @return Response
     */
    public function createTodo(CreateTodoRequest $createTodoRequest): Response
    {
        $response = $this->todoService->createTodo($createTodoRequest);
        $view = $this->view($response, 201);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/v1/todo")
     * @return Response
     */
    public function getTodos(): Response
    {
        $response = $this->todoService->getAllTodos();
        $view = $this->view($response, 200);
        return $this->handleView($view);
    }
}
