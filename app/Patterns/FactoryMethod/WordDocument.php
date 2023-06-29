<?php
declare(strict_types=1);

namespace FactoryMethod;

class WordDocument extends Document
{
    public function printContent()
    {
        return "Printing Word Document content";
    }
}
