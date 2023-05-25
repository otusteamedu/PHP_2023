<?php

namespace YakovGulyuta\Hw15\Infrasrtructure\Http;

use YakovGulyuta\Hw15\Application\Contract\CreateCinemaInterface;
use YakovGulyuta\Hw15\Application\Contract\UpdateCinemaInterface;
use YakovGulyuta\Hw15\Application\Dto\CreateCinemaRequest;
use YakovGulyuta\Hw15\Application\Dto\UpdateCinemaRequest;
use YakovGulyuta\Hw15\Domain\ValueObject\Name;

class CinemaController
{
    private CreateCinemaInterface $createCinema;

    private UpdateCinemaInterface $updateCinema;

    /**
     * @return void
     */
    public function createCinema(): void
    {
        $dto = new CreateCinemaRequest(
            new Name('Cinema Name'),
        );
        $response = $this->createCinema->handle($dto);

        http_response_code($response->code);
        echo $response->message;
    }

    /**
     * @return void
     */
    public function updateCinema()
    {
        $dto = new UpdateCinemaRequest(
            new Name('Cinema Name Update'),
            1,
        );
        $response = $this->updateCinema->handle($dto);

        http_response_code($response->code);
        echo $response->message;
    }
}
