<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Application\Response;

class GenerateReportResponse
{
    public function __construct(
        public string $message
    ) {
    }
}
