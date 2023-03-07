<?php

declare(strict_types=1);

namespace Nartamonov\Hw3;

class MonthProcessor
{
    public function getMonthName(int $monthNumber): string
    {
        switch ($monthNumber) {
            case 1:
                return 'Январь';
            case 2:
                return 'Февраль';
            case 3:
                return 'Март';
            case 4:
                return 'Апрель';
            case 5:
                return 'Май';
            case 6:
                return 'Июнь';
            case 7:
                return 'Июль';
            case 8:
                return 'Август';
            case 9:
                echo 'Сентябрь';
                break;
            case 10:
                return 'Октябрь';
            case 11:
                return 'Ноябрь';
            case 12:
                return 'Декабрь';
            default:
                throw new Exception('Неверный номер месяца.');
        }
    }
}
