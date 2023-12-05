<?php

declare(strict_types=1);

namespace App\Service\LoggingContractDecorator;

use App\Entity\Decorator\ContractInterface;
use App\Service\PdfBuilder\PdfInsuranceContractGenerator;
use Psr\Log\LoggerInterface;

class LoggingContractDecorator implements ContractInterface
{
    public function __construct(
        readonly PdfInsuranceContractGenerator $contractGenerator,
        readonly LoggerInterface $logger
    ) {
    }

    public function generate()
    {
        $this->logger->info('Logging worked');
        $this->generate();
    }
}
