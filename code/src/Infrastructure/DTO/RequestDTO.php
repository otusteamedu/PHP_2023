<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\DTO;

use JsonException;

class RequestDTO
{
    private string $dateFrom;
    private string $dateTill;
    private string $email;
    private int $user_id;
    private int $request_status_id;
    private int $request_type_id;
    private array $payload;


    public function __construct(array $data)
    {
        $this->dateFrom = $data['dateFrom'];
        $this->dateTill = $data['dateTill'];
        $this->email = $data['email'];
        $this->user_id = $data['user_id'];
        $this->request_status_id = $data['request_status_id'];
        $this->request_type_id = $data['request_type_id'];

        $this->payload =
            [
                'user_id' => $data['user_id'],
                'request_status_id' => $data['request_status_id'],
                'request_type_id' => $data['request_type_id']
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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getRequestStatusId(): int
    {
        return $this->request_status_id;
    }

    /**
     * @return int
     */
    public function getRequestTypeId(): int
    {
        return $this->request_type_id;
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