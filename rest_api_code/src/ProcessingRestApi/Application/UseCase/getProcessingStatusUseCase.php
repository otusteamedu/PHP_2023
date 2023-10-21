<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\OrderController\Application\UseCase;

class getProcessingStatusUseCase
{
    protected ProcessingMapperInterface $processingMapper;

    public function __construct(
        ProcessingMapperInterface $processingMapper
    ) {
        $this->processingMapper = $processingMapper;
    }

    public function getStatus(array $requestParams): array
    {
        /*
            $requestParams = [
                processingId => ...
            ]
        */

        $processing = $this->processingMapper->findById($requestParams["processing"]);
        return $processing->getStatus();
    }
}
