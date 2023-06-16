<?php

namespace MyApp;

class Validate {
    public function validateString($string) {
        // Проверяем непустоту строки
        $this->validateNotEmpty($string);

        // Проверяем корректность количества открытых и закрытых скобок
        $this->validateBrackets($string);
    }

    private function validateNotEmpty($string) {
        if (empty($string)) {
            throw new \Exception('Строка скобок пуста.');
        }
    }

    private function validateBrackets($string) {
        $openCount = 0;
        $closeCount = 0;

        // Перебираем каждый символ в строке
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];

            if ($char === '(') {
                $openCount++;
            } elseif ($char === ')') {
                $closeCount++;
            }

            // Если количество закрывающих скобок больше, чем открывающих,
            // или в конце строки остались незакрытые открывающие скобки,
            // выбрасываем исключение
            if ($closeCount > $openCount || ($i === strlen($string) - 1 && $openCount > $closeCount)) {
                throw new \Exception('Некорректное количество скобок.');
            }
        }

        // Если количество открывающих скобок не равно количеству закрывающих,
        // выбрасываем исключение
        if ($openCount !== $closeCount) {
            throw new \Exception('Некорректное количество скобок.');
        }
    }
}
