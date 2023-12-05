<?php

declare(strict_types=1);

namespace App\Service\PdfBuilder;

use Mpdf\Mpdf;
use Mpdf\MpdfException;

abstract class AbstractPdfContractGenerator
{
    /**
     * @throws MpdfException
     */
    final public function generate(): void
    {
        $mpdf = new Mpdf();
        $mpdf->WriteHTML("
                {$this->addHeader()}\n
                {$this->addPreamble()}\n
                {$this->addText()}\n
                {$this->addSignature()}\n
            ");
        $mpdf->Output();
    }

    abstract protected function addHeader(): string;

    abstract protected function addPreamble(): string;

    abstract protected function addText(): string;

    abstract protected function addSignature(): string;
}
