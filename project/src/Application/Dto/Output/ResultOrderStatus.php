<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

class ResultOrderStatus extends Result
{
    private ?string $status;

    public function __construct(bool $success, ?string $status = null, ?string $message = null)
    {
        parent::__construct($success, $message);
        $this->status = $status;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
}
