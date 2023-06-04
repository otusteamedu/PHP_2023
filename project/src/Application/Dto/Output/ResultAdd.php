<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

class ResultAdd extends Result
{
    private ?int $id;

    public function __construct(bool $success, ?string $message = null, ?int $id = null)
    {
        parent::__construct($success, $message);
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
