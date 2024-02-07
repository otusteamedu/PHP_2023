<?php

namespace old\code\src\NewCode\Application\UseCase\Request;

class StartAuctionRequest
{
    public function __construct(
        public string $title,
        public int $step
    )
    {
    }
}
