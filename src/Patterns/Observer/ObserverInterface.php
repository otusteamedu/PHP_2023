<?php

namespace App\Patterns\Observer;

interface ObserverInterface
{
    /**
     * Метод, вызываемый издателем при изменении состояния.
     *
     * @param string $event Тип события.
     * @param mixed $data Данные, связанные с событием.
     */
    public function update(string $event, $data = null): void;
}