<?php

namespace Sva;

use Sva\Email\FromInput;
use Sva\Email\FromFile;


class Email
{
    public static function validateFromInput(string $separator = ','): array
    {
        return (new FromInput())->validate($separator);
    }

    public static function validateFromFile(string $filePath): array
    {
        return (new FromFile())->validate($filePath);
    }
}