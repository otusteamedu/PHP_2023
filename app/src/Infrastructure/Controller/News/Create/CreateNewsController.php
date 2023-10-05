<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\News\Create;

use App\Application\Presenter\NewsPresenter;
use App\Application\UseCase\News\Create\CreateNews;
use App\Application\UseCase\News\Create\CreateNewsInput;
use App\Domain\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateNewsController extends AbstractController
{
    public function __construct(
        private readonly CreateNews $createNews,
        private readonly NewsPresenter $newsPresenter,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function handle(CreateNewsInput $input): JsonResponse
    {
        $news = $this->createNews->handle($input);

        return new JsonResponse([
            'data' => $this->newsPresenter->present($news),
        ]);
    }
}
