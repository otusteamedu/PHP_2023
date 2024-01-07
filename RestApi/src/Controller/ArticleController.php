<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public function __construct(private readonly ArticleRepository $articleRepository)
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/article', name: 'add_article')]
    public function addArticle(Request $request): Response
    {
        $content = $request->toArray();

        $article = new Article();
        $article->setName($content['name']);
        $article->setCreationDate(new DateTimeImmutable($content['creation_date']));

        $this->articleRepository->save($article);

        return new Response();
    }
}
