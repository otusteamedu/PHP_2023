<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

class getProcessingResultUseCase
{
    protected ProcessingMapperInterface $processingMapper;

    public function __construct(
        ProcessingMapperInterface $processingMapper
    ) {
        $this->processingMapper = $processingMapper;
    }

    public function getResult(array $requestParams): array
    {
        /*
            $requestParams = [
                processingId => ...
            ]
        */

        $processing = $this->processingMapper->findById($requestParams["processing"]);
        return $processing->getResult();
    }
}
