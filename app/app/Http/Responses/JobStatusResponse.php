<?php

declare(strict_types=1);

namespace App\Http\Responses;

class JobStatusResponse
{
    public string $status;

    /**
     * @param string $status
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array['status']
        );
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
