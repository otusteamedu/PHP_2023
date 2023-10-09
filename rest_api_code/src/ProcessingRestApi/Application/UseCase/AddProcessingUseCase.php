<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\UseCase;

class AddProcessingUseCase
{
    protected ProcessingMapperInterface $processingMapper;
    protected RabbitMqHelper $rabbitHelper;

    public function __construct(
        ProcessingMapperInterface $processingMapper,
        RabbitMqHelper $rabbitHelper
    ) {
        $this->processingMapper = $processingMapper;
        $this->rabbitHelper = $rabbitHelper;
    }

    public function add(array $requestParams): void
    {
        /*
            $requestParams = [
                
            ]


            actions:
            - check auth
            - save to postgres
            - sand queue mess
        */

        $processing = new Processing();
        $this->processingMapper->insert($processing);

        $message = json_encode($processing, JSON_UNESCAPED_UNICODE);
        $this->rabbitHelper->add("tasks", $message);
    }
}
