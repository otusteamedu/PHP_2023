<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\OperationCarReportDTO;
use App\Entity\Operation;
use App\Exception\NotFoundException;
use App\Exception\ValidationException;
use App\Manager\OperationManager;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class OperationService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CarReportService    $carReportService,
        private OperationManager    $operationManager,
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function executeOperationCarReportDTO(OperationCarReportDTO $operationCarReportDTO): void
    {
        $operation = $this->findById($operationCarReportDTO->getOperationId());
        $carReport = $this->carReportService->createReportByCarReportDTO($operationCarReportDTO->getCarReportDTO());
        $operation->setCarReport($carReport);

        $this->operationManager->emFlush();
    }

    /**
     * @throws NotFoundException
     */
    public function findById(int $id): Operation
    {
        /** @var OperationRepository $operationRepository */
        $operationRepository = $this->em->getRepository(Operation::class);
        $operation = $operationRepository->find($id);

        if (!$operation) {
            throw new NotFoundException(sprintf('not found operation with id = %s', $id));
        }

        return $operation;
    }
}
