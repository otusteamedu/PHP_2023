<?php

declare(strict_types=1);

namespace src\view;

class UserViewDTO
{
    private string $user;
    private string $event;
    private string $notify;
    private string $detail;

    public function __construct(array $data)
    {
        $this->user   = $data['user'];
        $this->event  = $data['event'];
        $this->notify = $data['notify'];
        $this->detail = $data['detail'];
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getNotify(): string
    {
        return $this->notify;
    }

    public function getDetail(): string
    {
        return $this->detail;
    }
}
