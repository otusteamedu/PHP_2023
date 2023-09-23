<?php

declare(strict_types=1);

namespace App\Music\Application\UseCase;

use App\Music\Application\Observer\NewTrackObserver\PublisherInterface;
use App\Music\Domain\Entity\Track;
use App\Music\Infrastructure\Repository\TrackRepository;

class CreateTrackUseCase
{
    private PublisherInterface $publisher;

    public function __construct(PublisherInterface $publisher, private readonly TrackRepository $trackRepository)
    {
        $this->publisher = $publisher;
    }

    public function execute(Track $track): void
    {
        $this->trackRepository->add($track);
        $this->publisher->notify($track);
    }
}
