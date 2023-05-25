<?php


namespace IilyukDmitryi\App\Validation;

interface Validation
{
    public function check(string $str): bool;

}