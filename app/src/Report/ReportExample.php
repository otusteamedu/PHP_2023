<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Report;

class ReportExample implements ReportInterface
{
    private string $key;

    /**
     * @param ReportExampleBuilder $builder
     */
    public function __construct(ReportExampleBuilder $builder)
    {
        $this->key = $builder->getKey();
    }

    public function makeReport(): string
    {
        return "Мы сделали отчет для {$this->key}, но его вам не отдадим!";
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
