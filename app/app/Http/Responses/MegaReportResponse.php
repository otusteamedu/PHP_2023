<?php

declare(strict_types=1);

namespace App\Http\Responses;

class MegaReportResponse
{
    public int $job_status_id;

    /**
     * @param int $job_status_id
     */
    public function __construct(int $job_status_id)
    {
        $this->job_status_id = $job_status_id;
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array['job_status_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'job_status_id' => $this->job_status_id,
        ];
    }
}
