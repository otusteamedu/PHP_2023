<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\CarReport;
use App\Entity\Enums\OperationStatus;
use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;

readonly class OperationManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function create(OperationStatus $status, CarReport $carReport = null): Operation
    {
        $operation = (new Operation())
            ->setStatus($status)
            ->setCarReport($carReport);
        $this->em->persist($operation);

        return $operation;
    }

    public function emFlush(): void
    {
        $this->em->flush();
    }
}
