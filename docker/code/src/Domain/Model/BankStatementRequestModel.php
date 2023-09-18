<?php

namespace IilyukDmitryi\App\Domain\Model;


use DateInterval;
use DateTime;
use Exception;

class BankStatementRequestModel
{

    private DateTime $dateStart;
    private DateTime $dateEnd;
    private string $email;

    public function __construct(DateTime $dateStart, DateTime $dateEnd, string $email)
    {
        $interval = new DateInterval('P1D');
        $diff = $dateEnd->diff($dateStart);
        $intervalCount = $diff->days / ($interval->d);

        if ($intervalCount === 0 || $dateStart >= $dateEnd) {
            throw new Exception(
                'Необходимо указать правильный диапазон дат, дата начала должна быть больше даты окончания.'
            );
        }

        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->email = $email;
    }

    /**
     * @return DateTime
     */
    public function getDateStart(): DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return DateTime
     */
    public function getDateEnd(): DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
