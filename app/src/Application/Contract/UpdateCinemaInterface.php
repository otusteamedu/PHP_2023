<?php

namespace YakovGulyuta\Hw15\Application\Contract;

use YakovGulyuta\Hw15\Application\Dto\UpdateCinemaRequest;
use YakovGulyuta\Hw15\Application\Dto\UpdateCinemaResponse;

interface UpdateCinemaInterface
{
    public function handle(UpdateCinemaRequest $createCinemaRequest): UpdateCinemaResponse;
}
