<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\CarReportDTO;
use App\DTO\OperationCarReportDTO;
use App\Entity\CarReport;
use App\Entity\Enums\OperationStatus;
use App\Entity\Operation;
use App\Exception\ValidationException;
use App\Manager\CarReportManager;
use App\Manager\OperationManager;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CarReportService
{
    public function __construct(
        private OperationManager    $operationManager,
        private AsyncService        $asyncService,
        private SerializerInterface $serializer,
        private CarReportManager    $carReportManager,
        private ValidatorInterface  $validator,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function createReportAsync(CarReportDTO $carReportDTO): int
    {
        $operation = $this->operationManager->create(OperationStatus::Running);
        $this->checkExistErrorsValidation($operation);

        $this->operationManager->emFlush();
        $operationCarReportDTO = new OperationCarReportDTO($operation->getId(), $carReportDTO);

        $this->asyncService->publishToExchange(
            AsyncService::CREATE_CAR_REPORT,
            $this->serializer->serialize($operationCarReportDTO, 'json')
        );

        return $operation->getId();
    }

    /**
     * @throws ValidationException
     */
    public function createReportByCarReportDTO(CarReportDTO $carReportDTO): CarReport
    {
        $reportData = $this->getDataByVIN($carReportDTO->getVIN());
        $carReport  = $this->carReportManager->create($carReportDTO->getVIN(), $reportData);
        $this->checkExistErrorsValidation($carReport);

        return $carReport;
    }

    //тут получение данных из разных источников
    private function getDataByVIN(string $VIN): string
    {
        sleep(15);

        return sprintf("Отчет для VIN=%s\n\n....тело отчета\n", $VIN);
    }

    /**
     * @throws ValidationException
     */
    private function checkExistErrorsValidation(CarReport|Operation $object): void
    {
        $errors = $this->validator->validate($object);

        if ($errors->count() > 0) {
            throw new ValidationException($errors);
        }
    }
}
