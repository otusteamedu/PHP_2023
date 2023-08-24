<?php

namespace Validators;

interface ValidatorContract
{
    /**
     * @return bool
     */
    public function passValidation(): bool;
}
