<?php
declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Output\OperationDTO;
use App\Entity\Enums\OperationStatus;
use App\Entity\Operation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class OperationDTOBuilder
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function buildFromEntity(Operation $operation): OperationDTO
    {
        $operationDTO = (new OperationDTO())
            ->setId($operation->getId())
            ->setStatus(match ($operation->getStatus()) {
                OperationStatus::Running => 'running',
                OperationStatus::Completed => 'completed',
            })
            ->setStartDateTime($operation->getCreatedAt());

        if ($operation->getCarReport()) {
            $operationDTO
                ->setEndDateTime($operation->getUpdatedAt())
                ->setUrl($this->urlGenerator->generate(
                    'api_v1_car_report_show',
                    ['id' => $operation->getCarReport()->getId()]
                ));
        }

        return $operationDTO;
    }
}
