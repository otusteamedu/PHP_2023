<?php

namespace YakovGulyuta\Hw15\Application\UseCase;

use Throwable;
use YakovGulyuta\Hw15\Application\Contract\CreateCinemaInterface;
use YakovGulyuta\Hw15\Application\Dto\CreateCinemaRequest;
use YakovGulyuta\Hw15\Application\Dto\CreateCinemaResponse;
use YakovGulyuta\Hw15\Domain\Contract\CinemaRepositoryInterface;
use YakovGulyuta\Hw15\Domain\Model\Cinema;

class CreateCinemaCase implements CreateCinemaInterface
{

    private CinemaRepositoryInterface $cinemaRepository;

    public function handle(CreateCinemaRequest $createCinemaRequest): CreateCinemaResponse
    {
        try {
            $cinemaRepository = $this->cinemaRepository;

            $cinema = new Cinema(
                $createCinemaRequest->name->getValue()
            );

            $cinemaRepository->save($cinema);

            $response = new CreateCinemaResponse(
                201,
                'Cinema Created'
            );
        } catch (Throwable $e) {
            $response = new CreateCinemaResponse(
                400,
                null,
                $e->getMessage()
            );
        }
        return $response;
    }
}