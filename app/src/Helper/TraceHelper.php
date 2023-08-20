<?php

declare(strict_types=1);

namespace App\Helper;

use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\TracerInterface;

class TraceHelper
{
    public function startSpan(string $name): SpanInterface
    {
        return $this->getTracer()->spanBuilder($name)->startSpan();
    }

    private function getTracer(): TracerInterface
    {
        return Globals::tracerProvider()->getTracer('app');
    }
}