<?php

namespace IilyukDmitryi\App\Application\Dto;

/**
 *
 */
class BankStatementRequest
{

    /**
     * @param string $uuid
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $email
     */
    public function __construct(private string $uuid, private string $dateStart, private string $dateEnd, private string $email)
    {
        $this->uuid = trim($uuid);
        $this->dateStart = trim($dateStart);
        $this->dateEnd = trim($dateEnd);
        $this->email = trim($email);
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
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
