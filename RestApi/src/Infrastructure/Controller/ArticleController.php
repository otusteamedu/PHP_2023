<?php

namespace App\Infrastructure\Controller;

use App\Domain\Dto\ArticleDto;
use App\Domain\Entity\Article;
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
        private readonly ArticleRepository $articleRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * @throws Exception
     */
    #[Route('/article', name: 'create_article', methods: ['POST'])]
    public function addArticle(Request $request): Response
    {
        $articleDto = $this->serializer->deserialize($request->getContent(), ArticleDto::class, 'json');

        $category = $this->categoryRepository->find($articleDto->getCategoryId());
        $author = $this->authorRepository->find($articleDto->getAuthorId());

        $article = new Article();
        $article->setName($articleDto->getName());
        $article->setCreationDate($articleDto->getCreationDate());
        $article->setAuthor($author);
        $article->addCategory($category);

        $this->articleRepository->save($article);

        return new Response('Ok!');
    }
}
