<?php

namespace YakovGulyuta\Hw15\Infrasrtructure\Command;

use Throwable;
use YakovGulyuta\Hw15\Application\Contract\CreateCinemaInterface;
use YakovGulyuta\Hw15\Application\Dto\CreateCinemaRequest;
use YakovGulyuta\Hw15\Domain\ValueObject\Name;

class CreateCinemaCommand
{

    private CreateCinemaInterface $createCinema;

    public function execute(string $name)
    {
        // получаем данные, мапим в Дто, валидируем, передаем в Кейс Создания

        try {
            $dto = new CreateCinemaRequest(
                new Name($name)
            );
            $this->createCinema->handle($dto);
            echo 1;
            exit;
        } catch (Throwable $e) {
            echo 0;
            // ошибку в логи
            exit;
        }

    }
}