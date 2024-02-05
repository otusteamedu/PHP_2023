<?php

namespace GKarman\CleanCode\NewCode\Application\UseCase\Request;

class StartAuctionRequest
{
    public function __construct(
        public string $title,
        public int $step
    )
    {
    }
}
