<?php
declare(strict_types=1);

namespace FactoryMethod;

use FactoryMethod;

class PDFDocumentCreator extends DocumentCreator
{
    public function createDocument(): Document
    {
        return new PDFDocument();
    }
}
