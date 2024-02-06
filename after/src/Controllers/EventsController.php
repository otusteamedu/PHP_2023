<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;

class EventsController extends Controller
{
    public function add(): string
    {
        if (!$this->getValidator()->validateArrayIsKeyExists($this->getRequest()->body(), ['conditions', 'priority', 'event'])) {
            $this->wrongBody();
        }

        try {
            $this->storage()->add(json_encode($this->getRequest()->body()['conditions']), $this->getRequest()->body()['priority'], $this->getRequest()->body()['event']);
            return 'Успешно добавлено новое событие';
        } catch (Exception $e) {
            $this->errorRequest($e);
        }

        return '';
    }

    public function read(): string
    {
        if (!$this->getValidator()->validateArrayIsKeyExists($this->getRequest()->body(), ['params'])) {
            $this->wrongBody();
        }

        try {
            $result = $this->storage()->read(json_encode($this->getRequest()->body()['params']));
            return $result[0] ?? 'Не найдено подходящих событий';
        } catch (Exception $e) {
            $this->errorRequest($e);
        }

        return '';
    }

    public function clear(): string
    {
        try {
            $this->storage()->deleteAll();
            return 'События успешно очищены';
        } catch (Exception $e) {
            $this->errorRequest($e);
        }

        return '';
    }
}
