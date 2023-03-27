<?php

namespace Pzagainov\Balancer;

use Pzagainov\Balancer\Exception\EmptyStringException;
use Pzagainov\Balancer\Exception\InvalidStringException;

class StringValidator
{
    /**
     * @throws EmptyStringException
     * @throws InvalidStringException
     */
    public function validate(string $string): bool
    {
        if (!$string) {
            throw new EmptyStringException();
        }

        $counter = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === '(') {
                $counter++;
            } elseif ($string[$i] === ')') {
                $counter--;
            }
            if ($counter < 0) {
                throw new InvalidStringException();
            }
        }

        return $counter === 0;
    }
}
