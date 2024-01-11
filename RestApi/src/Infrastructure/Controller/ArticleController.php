<?php

namespace App\Infrastructure\Controller;

use App\Application\Dto\ArticleDto;
use App\Application\UseCase\CreateArticleUseCase;
use App\Infrastructure\Repository\ArticleRepository;
use App\Infrastructure\Repository\AuthorRepository;
use App\Infrastructure\Repository\CategoryRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ArticleController extends AbstractController
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly ArticleRepository $articleRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * @throws Exception
     */
    #[Route('/article', name: 'create_article', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $articleDto = $this->serializer->deserialize($request->getContent(), ArticleDto::class, 'json');
        $createArticleUseCase = new CreateArticleUseCase($this->authorRepository, $this->categoryRepository);
        $article = $createArticleUseCase->create($articleDto);
        $this->articleRepository->save($article);

        return new Response('Ok!');
    }
}
