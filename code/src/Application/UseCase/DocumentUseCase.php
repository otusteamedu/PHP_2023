<?php

declare(strict_types=1);

namespace Art\Php2023\Application\UseCase;

use Art\Php2023\Domain\AbstractFactory\CommercialDocumentFactory;
use Art\Php2023\Domain\AbstractFactory\ResidentialDocumentFactory;
use Art\Php2023\Infrastructure\Exception\TypeNotFoundException;

class DocumentUseCase
{
    /**
     * @throws TypeNotFoundException
     */
    public function makePackageDocumentsByType(string $type): array
    {
        if ($type === 'Residential') {
            $selectedFactory = new ResidentialDocumentFactory();
        } else {
            if ($type === 'Commercial') {
                $selectedFactory = new CommercialDocumentFactory();
            } else {
                return throw new TypeNotFoundException('Need pass a valid type for make package documents');
            }
        }

        $document = $selectedFactory->makeDocument();
        $bill = $selectedFactory->makeBill();

        return [
            /*
             * Output: I am a commercial document OR I am a residential document
             * */
            'document' => $document->getDescription(),
            /*
             * Output: I am an invoice bill - I can be together only with a Commercial document OR
             * I am a receipt bill - I can be together only with a Residential document
             * */
            'document' => $bill->getDescription()
        ];
    }
}