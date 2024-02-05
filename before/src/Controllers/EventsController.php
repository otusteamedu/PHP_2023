<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Storage\StorageInterface;
use Exception;

class EventsController
{
    private mixed $input;

    public function __construct(readonly StorageInterface $storage)
    {
        $this->input = json_decode(file_get_contents("php://input"), true);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            $this->unSupport();
            return;
        }

        if (!array_key_exists('conditions', $this->input) || !array_key_exists('priority', $this->input) || !array_key_exists('event', $this->input)) {
            $this->wrongBody();
            return;
        }

        try {
            $this->storage->add(json_encode($this->input['conditions']), $this->input['priority'], $this->input['event']);
            echo 'Успешно добавлено новое событие';
        } catch (Exception $e) {
            $this->errorRequest($e);
        }
    }

    public function read(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->unSupport();
            return;
        }

        if (!array_key_exists('params', $this->input)) {
            $this->wrongBody();
            return;
        }

        try {
            $result = $this->storage->read(json_encode($this->input['params']));

            if (!$result) {
                echo 'Не найдено подходящих событий';
            } else {
                echo 'Подходящее событие: ' . $result[0];
            }
        } catch (Exception $e) {
            $this->errorRequest($e);
        }
    }

    public function clear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            $this->unSupport();
            return;
        }

        try {
            $this->storage->deleteAll();
            echo 'События успешно очищены';
        } catch (Exception $e) {
            $this->errorRequest($e);
        }
    }

    private function unSupport(): void
    {
        http_response_code(405);
        echo 'Неподдерживаемый метод';
    }

    private function wrongBody(): void
    {
        http_response_code(400);
        echo 'Неверное тело запроса';
    }

    private function errorRequest(Exception $exception): void
    {
        http_response_code(400);
        echo 'Ошибка запроса' . PHP_EOL;
        echo $exception->getMessage();
    }
}
