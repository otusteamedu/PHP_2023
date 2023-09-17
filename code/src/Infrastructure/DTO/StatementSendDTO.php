<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\DTO;

use JsonException;

class StatementSendDTO
{
    private string $dateFrom;

    private string $dateTill;

    private string $email;

    private array $payload;


    public function __construct(array $data)
    {
        $this->payload =
            [
                'dateFrom' => $data['dateFrom'],
                'dateTill' =>$data['dateTill'],
                'email' => $data['email'],
            ];
    }

    /**
     * @throws JsonException
     */
    public function toAMQPMessage(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR);
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateTill(): string
    {
        return $this->dateTill;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}