<?php

namespace IilyukDmitryi\App\Domain\Model;


use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

class BankStatementModel
{

    /**
     * @throws Exception
     */
    public function __construct(protected DateTime $dateStart, protected DateTime $dateEnd)
    {
    }

    public function getBankStatement()
    {
        static $bankStatement;

        if (is_null($bankStatement)) {
            $dateStart = $this->dateStart;
            $dateEnd = $this->dateEnd;

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($dateStart, $interval, $dateEnd);
            $bankStatement = [];

            foreach ($daterange as $date) {
                $bankStatement[] = [
                    'date' => $date,
                    'value' => mt_rand(0, 100)
                ];
            }
        }
        return $bankStatement;
    }

    public function getDateStart()
    {
        return $this->dateStart;
    }

    public function getDateEnd()
    {
        return $this->dateEnd;
    }
}
