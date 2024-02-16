<?php

namespace App\Patterns\Observer;

class PreparationObserver implements ObserverInterface
{
    /**
     * Обрабатывает уведомления о изменении статуса приготовления.
     *
     * @param string $event Тип события.
     * @param mixed $data Данные, связанные с событием.
     */
    public function update(string $event, $data = null): void
    {
        // Логика обработки различных типов событий
        switch ($event) {
            case 'order_prepared':
                $this->onOrderPrepared($data);
                break;
            case 'order_started':
                $this->onOrderStarted($data);
                break;
            // Добавьте другие случаи при необходимости
        }
    }

    /**
     * Обрабатывает событие начала приготовления заказа.
     *
     * @param mixed $data Данные о заказе.
     */
    protected function onOrderStarted($data): void
    {
        // Реализация логики при начале приготовления заказа
        echo "Приготовление заказа {$data['orderId']} начато.\n";
    }

    /**
     * Обрабатывает событие завершения приготовления заказа.
     *
     * @param mixed $data Данные о заказе.
     */
    protected function onOrderPrepared($data): void
    {
        // Реализация логики при завершении приготовления заказа
        echo "Заказ {$data['orderId']} готов.\n";
    }
}