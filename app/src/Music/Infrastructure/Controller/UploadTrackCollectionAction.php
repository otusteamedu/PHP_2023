<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Controller;

use App\Music\Application\MusicServiceInterface;
use App\Music\Infrastructure\Repository\TrackRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/music/track-collection', methods: ['POST'])]
class UploadTrackCollectionAction
{
    public function __construct(
        private readonly MusicServiceInterface $musicService,
        private readonly TrackRepository $trackRepository
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $requestBody = json_decode($request->getContent(), true);
        $this->trackRepository->uploadCollection($this->musicService->createUploadIterator($requestBody));
        return new JsonResponse('', Response::HTTP_CREATED, []);
    }
}
