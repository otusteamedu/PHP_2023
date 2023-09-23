<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Controller;

use App\Music\Application\MusicServiceInterface;
use App\Music\Application\Strategy\SortIteratorStrategy\NameSortIteratorStrategy;
use App\Music\Infrastructure\Repository\PlaylistRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/music/playlist-collection', methods: ['POST'])]
class UploadPlaylistCollectionAction
{
    public function __construct(
        private readonly MusicServiceInterface $musicService,
        private readonly PlaylistRepository $playlistRepository
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->playlistRepository->uploadCollection(
            $this->musicService->createUploadIterator(
                $request,
                new NameSortIteratorStrategy()
            )
        );
        return new JsonResponse('', Response::HTTP_CREATED, []);
    }
}
