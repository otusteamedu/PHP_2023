<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Report;

class ReportExampleBuilder
{
    private string $key;

    public function build(array $data): ReportExample
    {
        $this->key = $data['key'];

        return new ReportExample($this);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
