<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity;

use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Email;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Id;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateFrom;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateTo;

readonly class OrderReportRequest
{
    public function __construct(
        private readonly Id $userId,
        private readonly ReportDateFrom $dateFrom,
        private readonly ReportDateTo $dateTo,
        private readonly Email $emailTo,
    )
    {
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }

    public function getDateFrom(): ReportDateFrom
    {
        return $this->dateFrom;
    }

    public function getDateTo(): ReportDateTo
    {
        return $this->dateTo;
    }

    public function getEmailTo(): Email
    {
        return $this->emailTo;
    }
}
