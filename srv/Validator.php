<?php

declare(strict_types=1);

namespace App;

class Validator
{
    private bool $result = true;
    private ?string $string = null;

    public function validateString(?string $string): bool
    {
        $this->string = $string;
        $this->checkNullable();
        if (!$this->result) {
            return $this->result;
        }
        $this->checkBrackets();

        return $this->result;
    }

    private function checkNullable(): void
    {
        if (!$this->string) {
            $this->result = false;
        }
    }

    private function checkBrackets(): void
    {
        $number = 0;
        foreach (str_split($this->string) as $element) {
            if ($element === "(") {
                ++$number;
            } elseif ($element === ")") {
                --$number;
            }
        }

        if ($number !== 0) {
            $this->result = false;
        }
    }
}
