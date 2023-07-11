<?php

namespace app\Rules;

interface Rule
{
    public function passes($value): bool;
}
