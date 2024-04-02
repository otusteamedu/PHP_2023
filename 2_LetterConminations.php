<?php

$result = (new Solution())->letterCombinations('729665');

foreach($result as $resultItem) {
    echo $resultItem . ' ';
}

class Solution
{
    /**
     * @param string $digits
     * @return string[]
     */
    function letterCombinations($digits)
    {
        $result = [];

        // Проверяем параметр
        if (empty($digits)) {
            return $result;
        }

        // Определяем кнопку по вервой цифре 
        $digit = (int)$digits[0];
        // Определяем количество букв на кнопке
        $rowLength = ($digit === 7 || $digit === 9 ? 4 : 3);
        // Определяем позицию первой буквы на кнопке
        $offset = ($digit - 2) * 3 + ($digit > 7 ? 1 : 0);
        // Рекурсивно получаем массив оставшихся комбинаций
        $tails = $this->letterCombinations(substr($digits, 1));

        // Перебираем буквы на кнопке
        for ($rowItem = 0; $rowItem < $rowLength; $rowItem++) {
            // Получаем букву
            $letter = chr(97 + $offset + $rowItem);
            if(!empty($tails)) {
                // Если массив хвостов заполнен, добавляем в результаты
                // текущую букву + каждый хвост
                foreach ($tails as $tail) {
                    $result[] = $letter . $tail;
                }
            } else {
                // Если массив хвостов пуст - добавляем в результаты
                // текущую букву
                $result[] = $letter;
            }
        }

        // Возвращаем результаты
        return $result;
    }
}
