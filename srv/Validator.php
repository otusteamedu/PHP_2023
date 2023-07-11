<?php

declare(strict_types=1);

class Validator
{
    private bool $result = true;
    private null|string $string = null;

    public function validateString(null|string $string): bool
    {
        $this->string = $string;

        $this->checkNullable();

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
        // Идея в том, чтобы перебирая все элементы если (, то прибавлять + если ), то
        // отнимать. Если итоговое значение 0, то все отлично.
    }

}