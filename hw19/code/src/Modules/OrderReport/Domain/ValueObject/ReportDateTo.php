<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject;

use InvalidArgumentException;

class ReportDateTo
{
    private \DateTime $dateTo;
    public function __construct(string $date)
    {
        $this->assertValidValue($date);
        $this->dateTo = new \DateTime($date);
    }

    public function getValue(): \DateTime
    {
        return $this->dateTo;
    }

    private function assertValidValue(string $date): void
    {
        $format = 'Y-m-d';
        $dateTo = \DateTime::createFromFormat($format, $date);

        if (!$dateTo || $dateTo->format($format) !== $date) {
            throw new InvalidArgumentException('Дата не валидна или не соответствует формату Y-m-d');
        }

        $nowDate = new \DateTime();
        if ($dateTo > $nowDate) {
            throw new InvalidArgumentException('Дата не должна быть более '.  $nowDate->format('Y-m-d'));
        }
    }
}
