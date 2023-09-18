<?php

namespace IilyukDmitryi\App\Application\Dto;

class MessageBankStatement
{
    private string $dateStart;
    private string $dateEnd;
    private string $email;

    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $email
     */
    public function __construct(string $dateStart, string $dateEnd, string $email)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    /**
     * @return string
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }
}
