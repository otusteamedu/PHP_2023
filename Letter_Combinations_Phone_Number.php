<?php

class Solution {

    /**
     * @param String $digits
     * @return String[]
     */

    function letterCombinations($digits) {

        if (empty($digits)) {
            return [];
        }

        $digitToLetters = [
            '2' => 'abc', '3' => 'def', '4' => 'ghi', '5' => 'jkl',
            '6' => 'mno', '7' => 'pqrs', '8' => 'tuv', '9' => 'wxyz'
        ];

        $result = [];
        $this->backtrack('', $digits, $result, $digitToLetters);
        return $result;

    }

    function backtrack($combination, $nextDigits, &$result, $digitToLetters) {
        // Если больше нет цифр для проверки
        if (empty($nextDigits)) {
            // Комбинация завершена
            $result[] = $combination;
        } else {
            // Получаем буквы, соответствующие следующей доступной цифре
            $letters = $digitToLetters[$nextDigits[0]];
            // Для каждой буквы вариантов
            for ($i = 0; $i < strlen($letters); $i++) {
                // Добавляем текущую букву к комбинации и переходим к следующим цифрам
                $this->backtrack($combination . $letters[$i], substr($nextDigits, 1), $result, $digitToLetters);
            }
        }
    }

}

$solution = new Solution();
$solution->letterCombinations(23);
$solution->letterCombinations('');
$solution->letterCombinations(2);