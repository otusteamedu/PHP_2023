<?php

namespace YakovGulyuta\Hw15\Application\Contract;

use YakovGulyuta\Hw15\Application\Dto\CreateCinemaRequest;
use YakovGulyuta\Hw15\Application\Dto\CreateCinemaResponse;

interface CreateCinemaInterface
{
    public function handle(CreateCinemaRequest $createCinemaRequest): CreateCinemaResponse;
}
