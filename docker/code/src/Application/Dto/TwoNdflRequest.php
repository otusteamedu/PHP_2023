<?php

namespace IilyukDmitryi\App\Application\Dto;

/**
 *
 */
class TwoNdflRequest
{
    /**
     * @param string $uuid
     * @param int $numMonth
     * @param string $email
     */
    public function __construct(private string $uuid, private int $numMonth, private string $email)
    {
        $this->numMonth = (int)($numMonth);
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
