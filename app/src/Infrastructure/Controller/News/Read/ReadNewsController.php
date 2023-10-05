<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\News\Read;

use App\Application\Presenter\NewsPresenter;
use App\Application\UseCase\News\Read\ReadNews;
use App\Application\UseCase\News\Read\ReadNewsInput;
use App\Domain\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ReadNewsController extends AbstractController
{
    public function __construct(
        private readonly ReadNews $readNews,
        private readonly NewsPresenter $newsPresenter,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function handle(ReadNewsInput $input): JsonResponse
    {
        $news = $this->readNews->handle($input);

        return new JsonResponse([
            'data' => $this->newsPresenter->present($news),
        ]);
    }
}
