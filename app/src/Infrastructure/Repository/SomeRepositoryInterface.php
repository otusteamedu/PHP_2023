<?php

namespace App\Infrastructure\Repository;

interface SomeRepositoryInterface
{
    /**
     * Метод проверяет соответствие номера заказа
     * и его суммы и возвращает true, еслисписание успешно
     *
     * @param string $orderNumber
     * @param float $sum
     * @return bool
     */
    public function setOrderIsPaid(string $orderNumber, float $sum): bool;
}
