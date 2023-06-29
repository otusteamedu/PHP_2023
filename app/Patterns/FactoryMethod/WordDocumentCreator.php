<?php
declare(strict_types=1);

namespace FactoryMethod;

use FactoryMethod;

class WordDocumentCreator extends DocumentCreator
{
    public function createDocument(): Document
    {
        return new WordDocument();
    }
}
