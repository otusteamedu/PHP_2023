<?php

namespace WorkingCode\Hw12\Command;

use WorkingCode\Hw12\Exception\InvalidArgumentException;

trait CommandTrait
{
    /**
     * @throws InvalidArgumentException
     */
    private function checkStringArgument(string $string): void
    {
        if (empty($string)) {
            throw new InvalidArgumentException('Аргумент не имеет значения');
        }

        if (!str_contains($string, '=')) {
            throw new InvalidArgumentException('Аргумент должен содержать имя параметра и его значение');
        }
    }
}
