<?php
namespace HW11\Elastic\DI\Observer;
// Наблюдатель
class CookingStatusObserver extends \HW11\Elastic\DI\Observer\CookingSubject
{
    /**
     * @param string $status
     * @return void
     */
    public function update(string $status): void
    {
        echo "Статус приготовления обновлен: $status\n";
    }
}
