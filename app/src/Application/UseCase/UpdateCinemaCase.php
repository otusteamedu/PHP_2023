<?php

namespace YakovGulyuta\Hw15\Application\UseCase;

use Throwable;
use YakovGulyuta\Hw15\Application\Contract\UpdateCinemaInterface;
use YakovGulyuta\Hw15\Application\Dto\UpdateCinemaRequest;
use YakovGulyuta\Hw15\Application\Dto\UpdateCinemaResponse;
use YakovGulyuta\Hw15\Domain\Contract\CinemaRepositoryInterface;
use YakovGulyuta\Hw15\Domain\Exception\EntityNotFoundException;

class UpdateCinemaCase implements UpdateCinemaInterface
{
    private CinemaRepositoryInterface $cinemaRepository;

    public function handle(UpdateCinemaRequest $createCinemaRequest): UpdateCinemaResponse
    {
        try {
            $cinemaRepository = $this->cinemaRepository;

            /**@var \YakovGulyuta\Hw15\Domain\Model\Cinema $cinema */
            $cinema = $cinemaRepository->findOne($createCinemaRequest->cinema_id);

            if ($cinema === null) {
                throw new EntityNotFoundException('Cinema does not found', 400);
            }

            $cinema->setName($createCinemaRequest->name);

            $cinemaRepository->save($cinema);

            $response = new UpdateCinemaResponse(
                200,
                'Cinema Updated',
            );
        } catch (Throwable $e) {
            $response = new UpdateCinemaResponse(
                $e->getCode(),
                null,
                $e->getMessage(),
            );
        }

        return $response;
    }
}
