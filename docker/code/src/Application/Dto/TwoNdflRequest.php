<?php

namespace IilyukDmitryi\App\Application\Dto;

class TwoNdflRequest
{
    private string $numMonth;
    private string $email;

    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $email
     */
    public function __construct(int $numMonth, string $email)
    {
        $this->numMonth = (int)($numMonth);
        $this->email = trim($email);
    }

    /**
     * @return string
     */
    public function getNumMonth(): string
    {
        return $this->numMonth;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
