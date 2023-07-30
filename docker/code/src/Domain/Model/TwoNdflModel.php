<?php

namespace IilyukDmitryi\App\Domain\Model;


use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

class TwoNdflModel
{

    /**
     * @throws Exception
     */
    public function __construct(protected int $numMonth)
    {
    }

    public function getReference()
    {
        static $twondfl;

        if (is_null($twondfl)) {
            $dateEnd = (new DateTime())->modify("-1 day");
            $dateStart = (new DateTime())->modify("-" . $this->numMonth . " month");

            $interval = new DateInterval('P1M');
            $daterange = new DatePeriod($dateStart, $interval, $dateEnd);
            $twondfl = [];

            foreach ($daterange as $date) {
                $twondfl[] = [
                    'date' => $date,
                    'value' => mt_rand(0, 10000)
                ];
            }
        }
        return $twondfl;
    }

    public function getNumMonth(): int
    {
        return $this->numMonth;
    }

}
