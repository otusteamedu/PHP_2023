<?php
declare(strict_types=1);

namespace FactoryMethod;

use FactoryMethod;

$pdfCreator = new FactoryMethod\PDFDocumentCreator();
echo $pdfCreator->printDocument();

$wordCreator = new WordDocumentCreator();
echo $wordCreator->printDocument();
