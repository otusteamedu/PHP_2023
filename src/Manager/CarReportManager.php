<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\CarReport;
use Doctrine\ORM\EntityManagerInterface;

readonly class CarReportManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function create(string $VIN, string $data): CarReport
    {
        $carReport = (new CarReport())
            ->setVIN($VIN)
            ->setData($data);
        $this->em->persist($carReport);

        return $carReport;
    }
}
