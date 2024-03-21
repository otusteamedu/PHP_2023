<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity;

use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Email;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Id;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateFrom;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateTo;

class OrderReportRequest
{
    public function __construct(
        private Id $userId,
        private ReportDateFrom $dateFrom,
        private ReportDateTo $dateTo,
        private Email $emailTo,
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
