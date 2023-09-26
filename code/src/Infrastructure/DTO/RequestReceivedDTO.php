<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\DTO;

class RequestReceivedDTO
{
    private string $dateFrom;
    private string $dateTill;
    private string $email;
    private int $user_id;
    private int $request_type_id;
    private int $request_status_id;
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
                'dateFrom' => $data['dateFrom'],
                'dateTill' => $data['dateTill'],
                'email' => $data['email'],
                'user_id' => $data['user_id'],
                'request_status_id' => $data['request_status_id'],
                'request_type_id' => $data['request_type_id']
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

    /**
     * @return int|mixed
     */
    public function getUserId(): mixed
    {
        return $this->user_id;
    }

    /**
     * @return int|mixed
     */
    public function getRequestTypeId(): mixed
    {
        return $this->request_type_id;
    }

    /**
     * @return int|mixed
     */
    public function getRequestStatusId(): mixed
    {
        return $this->request_status_id;
    }

    /**
     * @param int|mixed $request_status_id
     */
    public function setRequestStatusId(mixed $request_status_id): void
    {
        $this->request_status_id = $request_status_id;
    }
}