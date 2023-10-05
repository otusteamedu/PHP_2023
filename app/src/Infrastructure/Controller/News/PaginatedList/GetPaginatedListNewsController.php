<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\News\PaginatedList;

use App\Application\Presenter\NewsPresenter;
use App\Application\Presenter\PaginationPresenter;
use App\Application\UseCase\News\PaginatedList\GetPaginatedListNews;
use App\Application\UseCase\News\PaginatedList\GetPaginatedListNewsInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetPaginatedListNewsController extends AbstractController
{
    public function __construct(
        private readonly GetPaginatedListNews $getPaginatedListNews,
        private readonly NewsPresenter $newsPresenter,
        private readonly PaginationPresenter $paginationPresenter,
    ) {
    }

    public function handle(GetPaginatedListNewsInput $input): JsonResponse
    {
        $result = $this->getPaginatedListNews->handle($input);

        return new JsonResponse([
            'data' => array_map(
                fn ($news) => $this->newsPresenter->present($news),
                $result->news,
            ),
            'meta' => $this->paginationPresenter->present($result->pagination),
        ]);
    }
}
