<?php

namespace App\Application\Dto;

use DateTime;

readonly class TransactionsInfoDto
{
    public function __construct(private DateTime $dateFrom, private DateTime $dateTo, private string $chatId = '')
    {
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }
}
