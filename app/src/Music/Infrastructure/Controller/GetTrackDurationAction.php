<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Controller;

use App\Music\Domain\Decorator\Track\DurationTrackDecorator;
use App\Music\Infrastructure\Repository\TrackRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetTrackDurationAction
{
    public function __construct(
        private readonly TrackRepository $trackRepository
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $track = $this->trackRepository->findById($request['id']);
        $decoratedTrack = new DurationTrackDecorator($track);
        return new JsonResponse($decoratedTrack->getDuration(), Response::HTTP_OK, []);
    }
}
