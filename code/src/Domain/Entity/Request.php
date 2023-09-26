<?php

declare(strict_types=1);

namespace Art\Code\Domain\Entity;

class Request
{
    private RequestStatus $status;
    private User $user;
    private RequestType $type;

    /**
     * @return RequestStatus
     */
    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    /**
     * @param RequestStatus $status
     */
    public function setStatus(RequestStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return RequestType
     */
    public function getType(): RequestType
    {
        return $this->type;
    }

    /**
     * @param RequestType $type
     */
    public function setType(RequestType $type): void
    {
        $this->type = $type;
    }
}