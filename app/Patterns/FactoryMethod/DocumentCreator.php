<?php
declare(strict_types=1);

namespace FactoryMethod;

use FactoryMethod;

abstract class DocumentCreator
{
    abstract public function createDocument(): FactoryMethod\Document;

    public function printDocument()
    {
        $document = $this->createDocument();
        return $document->printContent();
    }
}
