<?php

namespace IilyukDmitryi\App\Form;

class View
{
    public static function show(string $emails): void
    {
        include "Template/Form.php";
    }
}
