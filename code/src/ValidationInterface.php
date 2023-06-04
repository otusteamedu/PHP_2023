<?php

namespace Ayagudin\BrackersValid;

interface ValidationInterface
{
    public function validation(): void;
    public function getStatusCode(): int;
    public function getResult(): string;

}