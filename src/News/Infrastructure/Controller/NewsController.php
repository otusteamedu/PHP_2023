<?php

declare(strict_types=1);

namespace App\News\Infrastructure\Controller;

use App\News\Application\Dto\NewsDto;
use App\News\Application\Dto\UserDto;
use App\News\Application\UseCase\CreateNewsUseCase;
use App\News\Domain\Notifier\NewsSubject;
use App\News\Domain\Orm\Category;
use App\News\Domain\Paginator\NewsPaginator;
use App\News\Infrastructure\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final readonly class NewsController
{
    public function __construct(
        private CreateNewsUseCase $createNewsUseCase,
        private SerializerInterface $serializer,
        private NewsRepository $newsRepository,
        private NewsSubject $newsSubject,
        private NewsPaginator $paginator,
    ) {
    }

    #[Route('/news', methods: ['GET'])]
    public function all(#[MapQueryParameter] int $page): Response
    {
        $newsCollection = $this->paginator->paginate($page);

        $newsList = [];
        foreach ($newsCollection as $news) {
            $newsList[] = $news;
        }

        $newsData = [
            'currentPage' => $page,
            'perPage' => 2,
            'newsItems' => $newsList,
        ];

        $serializedNews = $this->serializer->serialize($newsData, 'json');
        return new JsonResponse($serializedNews, json: true);
    }

    #[Route('/news/{id}', methods: ['GET'])]
    public function one(int $id): Response
    {
        $news = $this->newsRepository->find($id);
        $serializedNews = $this->serializer->serialize($news, 'json');
        return new JsonResponse($serializedNews, json: true);
    }

    #[Route('/news', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $newsDto = $this->serializer->deserialize($request->getContent(), NewsDto::class, 'json');

        $this->createNewsUseCase->create($newsDto);

        return new JsonResponse(["result" => "You have created news successfully!"]);
    }

    #[Route('/news/{category}/subscribe/', methods: ['POST'])]
    public function subscribe(Category $category, #[MapRequestPayload] UserDto $userDto): Response
    {
        $this->newsSubject->observe($category, $userDto->getEmail());
 
        return new JsonResponse(["result" => "You've been successfully subscribed!"]);
    }
}
