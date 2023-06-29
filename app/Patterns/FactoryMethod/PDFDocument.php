<?php
declare(strict_types=1);

namespace FactoryMethod;

class PDFDocument extends Document
{
    public function printContent()
    {
        return "Printing PDF Document content";
    }
}
