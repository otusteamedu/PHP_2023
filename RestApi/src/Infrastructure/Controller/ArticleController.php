<?php

namespace App\Infrastructure\Controller;

use App\Application\Dto\ArticleDto;
use App\Application\UseCase\CreateArticleUseCase;
use App\Infrastructure\Repository\ArticleRepository;
use App\Infrastructure\Repository\AuthorRepository;
use App\Infrastructure\Repository\CategoryRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/article/{id}', methods: ['GET'])]
    public function one(int $id): JsonResponse
    {
        $article = $this->articleRepository->find($id);
        $serializedArticle = $this->serializer->serialize(
            $article,
            'json',
            [
                'groups' => [
                    'Article',
                    'Author',
                    'Category'
                ],
            ]);

        return new JsonResponse($serializedArticle, json: true);
    }

    #[Route('/article', methods: ['GET'])]
    public function all(): JsonResponse
    {
        $news = $this->articleRepository->findAll();
        $serializedNews = $this->serializer->serialize(
            $news,
            'json',
            [
                'groups' => [
                    'Article',
                    'Author',
                    'Category'
                ],
            ]);

        return new JsonResponse($serializedNews, json: true);
    }

    /**
     * @throws Exception
     */
    #[Route('/article', name: 'create_article', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $articleDto = $this->serializer->deserialize($request->getContent(), ArticleDto::class, 'json');
            $createArticleUseCase = new CreateArticleUseCase($this->authorRepository, $this->categoryRepository);
            $article = $createArticleUseCase->create($articleDto);
            $this->articleRepository->save($article);
        } catch (Exception $e) {
            return new JsonResponse(['result' => 'Error while creating article: ' . $e->getMessage()]);
        }

        return new JsonResponse(['result' => 'Article have been created.']);
    }
}
