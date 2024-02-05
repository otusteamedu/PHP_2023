<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;

class EventsController extends Controller
{
    public function add(): void
    {
        if (!$this->getValidator()->validateArrayIsKeyExists($this->getRequest()->body(), ['conditions', 'priority', 'event'])) {
            $this->wrongBody();
        }

        try {
            $this->storage()->add(json_encode($this->getRequest()->body()['conditions']), $this->getRequest()->body()['priority'], $this->getRequest()->body()['event']);
            echo 'Успешно добавлено новое событие';
        } catch (Exception $e) {
            $this->errorRequest($e);
        }
    }

    public function read(): void
    {
        if (!$this->getValidator()->validateArrayIsKeyExists($this->getRequest()->body(), ['params'])) {
            $this->wrongBody();
        }

        try {
            $result = $this->storage()->read(json_encode($this->getRequest()->body()['params']));

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
        try {
            $this->storage()->deleteAll();
            echo 'События успешно очищены';
        } catch (Exception $e) {
            $this->errorRequest($e);
        }
    }
}
