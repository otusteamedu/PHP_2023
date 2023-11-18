<?php
declare(strict_types=1);

function calculateDaysLived($birthday) {

    /*
     * Преобразовываем строку с датой в формат 'ГГГГ-ММ-ДД' для объекта класса DateTime
     * */

    $birthday = explode('.', $birthday);
    $birthday = array_reverse($birthday);
    $birthday = implode('-', $birthday);

    $birthdayDate = new DateTime($birthday);

    /*
     * Получаем текущую дату
     * */

    $currentDate = new DateTime();

    /*
     * Вычисляем разницу между датами и приводим результат к объекту класса DateInterval
     * */

    return $currentDate->diff($birthdayDate)->days;
}

/*
 * Пример использования функции
 * */

$daysLived = calculateDaysLived('13-01-1986');
echo "Вы прожили $daysLived дней";