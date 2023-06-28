<?php
declare(strict_types=1);

abstract class Document
{
    abstract public function printContent();
}

class PDFDocument extends Document
{
    public function printContent()
    {
        return "Printing PDF Document content";
    }
}

class WordDocument extends Document
{
    public function printContent()
    {
        return "Printing Word Document content";
    }
}

abstract class DocumentCreator
{
    abstract public function createDocument(): Document;

    public function printDocument()
    {
        $document = $this->createDocument();
        return $document->printContent();
    }
}

class PDFDocumentCreator extends DocumentCreator
{
    public function createDocument(): Document
    {
        return new PDFDocument();
    }
}

class WordDocumentCreator extends DocumentCreator
{
    public function createDocument(): Document
    {
        return new WordDocument();
    }
}

$pdfCreator = new PDFDocumentCreator();
echo $pdfCreator->printDocument();

$wordCreator = new WordDocumentCreator();
echo $wordCreator->printDocument();
