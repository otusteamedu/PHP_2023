<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject;

use InvalidArgumentException;

class ReportDateFrom
{
    private \DateTime $dateFrom;
    public function __construct(string $date)
    {
        $this->assertValidValue($date);
        $this->dateFrom = new \DateTime($date);
    }

    public function getValue(): \DateTime
    {
        return $this->dateFrom;
    }

    private function assertValidValue(string $date): void
    {
        $format = 'Y-m-d';
        $dateFrom = \DateTime::createFromFormat($format, $date);

        if (!$dateFrom || $dateFrom->format($format) !== $date) {
            throw new InvalidArgumentException('Дата не валидна или не соответствует формату Y-m-d');
        }

        $earliestDate = new \DateTime('2020-01-01');
        if ($dateFrom < $earliestDate) {
            throw new InvalidArgumentException('Дата должна быть более '.  $earliestDate->format('Y-m-d'));
        }
    }
}
