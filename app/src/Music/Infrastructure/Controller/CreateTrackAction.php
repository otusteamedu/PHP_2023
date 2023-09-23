<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Controller;

use App\Music\Application\Observer\NewTrackObserver\EmailNotifierService;
use App\Music\Application\Observer\NewTrackObserver\Publisher;
use App\Music\Application\UseCase\CreateTrackUseCase;
use App\Music\Domain\Entity\Track;
use App\Music\Infrastructure\Repository\GenreRepository;
use App\Music\Infrastructure\Repository\TrackRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateTrackAction
{
    public function __construct(
        private readonly TrackRepository $trackRepository,
        private readonly GenreRepository $genreRepository
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $track = new Track(
            $request['name'],
            $request['author'],
            $request['duration'],
            $this->genreRepository->findById($request['genre_id'])
        );

        $publisher = new Publisher();
        $publisher->subscribe(new EmailNotifierService());
        $useCase = new CreateTrackUseCase($publisher, $this->trackRepository);
        $useCase->execute($track);

        return new JsonResponse('', Response::HTTP_CREATED, []);
    }
}
