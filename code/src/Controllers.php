<?php

namespace Ayagudin\BrackersValid;

class Controllers
{
    private string $string;
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @return ValidationInterface
     */
    public function getValidatorForString(): ValidationInterface
    {
        return new ValidatorString($this->string);
    }

}