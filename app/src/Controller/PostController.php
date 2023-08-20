<?php

namespace App\Controller;

use App\Dto\PostDto;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/post')]
class PostController extends AbstractController
{
    public function __construct(
        private readonly PostService $postService,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route('/', methods: 'POST')]
    public function create(#[MapRequestPayload] PostDto $postDto): Response
    {
        return new Response(
            content: $this->postService->create($postDto),
            status: Response::HTTP_CREATED,
        );
    }

    #[Route('/{id}', methods: 'GET')]
    public function findById(int $id): Response
    {
        return new Response(
            $this->serializer->serialize(
                $this->postService->getById($id),
                'json'
            )
        );
    }

    #[Route('/', methods: 'GET')]
    public function findAll(): Response
    {
        return new Response(
            $this->serializer->serialize(
                $this->postService->findAll(),
                'json'
            )
        );
    }

    #[Route('/', methods: 'PUT')]
    public function update(#[MapRequestPayload] PostDto $postDto): Response
    {
        $this->postService->update($postDto);
        return new Response();
    }

    #[Route('/{id}', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        $this->postService->delete($id);
        return new Response();
    }
}
