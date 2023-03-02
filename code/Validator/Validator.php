<?php
declare(strict_types=1);

namespace Validator;

use Exceptions\InvalidCountException;
use Exceptions\NotAStringException;
use Exceptions\NotClosedExcaption;

class Validator
{
    public function __construct(readonly string $string)
    {
    }

    private function validateIsString()
    {
        // Check if the input is valid
        if (!$this->string || !is_string($this->string)) {
            throw new NotAStringException();
        }

        return $this;
    }

    private function validateCount()
    {
// Count the number of open and closed parentheses
        $open_count = substr_count($this->string, '(');
        $close_count = substr_count($this->string, ')');

// Check if the number of open and closed parentheses is equal
        if ($open_count !== $close_count) {
            throw new InvalidCountException();
        }

        return $this;
    }

    private function checkClosed()
    {
        // Check if the parentheses are correctly balanced
        $stack = [];
        for ($i = 0; $i < strlen($this->string); $i++) {
            if ($this->string[$i] === '(') {
                array_push($stack, '(');
            } elseif ($this->string[$i] === ')') {
                if (empty($stack)) {
                    throw new NotClosedExcaption();
                } else {
                    array_pop($stack);
                }
            }
        }

// If the stack is not empty, the parentheses are not balanced
        if (!empty($stack)) {
            throw new NotClosedExcaption();
        }

        return $this;
    }

    /**
     * @return true
     * @throws InvalidCountException
     * @throws NotAStringException
     * @throws NotClosedExcaption
     */
    public function validate()
    {
        $this->validateIsString()->validateCount()->checkClosed();

        return true;
    }
}
