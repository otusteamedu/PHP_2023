<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\DTO;

class StatementReceivedDTO
{
    private string $dateFrom;

    private string $dateTill;

    private string $email;

    private array $payload;


    public function __construct(array $data)
    {
        $this->dateFrom = $data['dateFrom'] ;
        $this->dateTill = $data['dateTill'] ;
        $this->email = $data['email'] ;

        $this->payload =
            [
                'dateFrom' => $data['dateFrom'],
                'dateTill' =>$data['dateTill'],
                'email' => $data['email'],
            ];
    }

    /**
     * @return mixed|string
     */
    public function getDateFrom(): mixed
    {
        return $this->dateFrom;
    }

    /**
     * @return mixed|string
     */
    public function getDateTill(): mixed
    {
        return $this->dateTill;
    }

    /**
     * @return mixed|string
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }
}