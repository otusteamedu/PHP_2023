<?php

declare(strict_types=1);

namespace Root\App\Data;

use DateTime;
use JsonSerializable;
use Root\App\AppException;
use Root\App\TypeHelper;

class TaskDto implements JsonSerializable
{
    public ?string $id = null;
    public ?DateTime $add_timestamp = null;
    public ?string $body = null;
    public ?DateTime $exec_timestamp = null;
    public ?DateTime $finish_timestamp = null;
    public TaskStatus $status = TaskStatus::Created;

    public function setId(?string $id): TaskDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @throws AppException
     */
    public function setAddTimestamp(DateTime|string|null $add_timestamp): TaskDto
    {
        $this->add_timestamp = TypeHelper::toDatetime($add_timestamp);
        return $this;
    }

    public function setBody(?string $body): TaskDto
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @throws AppException
     */
    public function setExecTimestamp(DateTime|string|null $exec_timestamp): TaskDto
    {
        $this->exec_timestamp = TypeHelper::toDatetime($exec_timestamp);
        return $this;
    }

    /**
     * @throws AppException
     */
    public function setFinishTimestamp(DateTime|string|null $finish_timestamp): TaskDto
    {
        $this->finish_timestamp = TypeHelper::toDatetime($finish_timestamp);
        return $this;
    }

    /**
     * @throws AppException
     */
    public function setStatus(TaskStatus|string|null $status): TaskDto
    {
        $this->status = TypeHelper::toEnum($status, TaskStatus::class);
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'add_datetime' => $this->add_timestamp?->format(TypeHelper::DATETIME_FORMAT_TIMESTAMP),
            'body' => $this->body,
            'exec_timestamp' => $this->exec_timestamp?->format(TypeHelper::DATETIME_FORMAT_TIMESTAMP),
            'finish_timestamp' => $this->finish_timestamp?->format(TypeHelper::DATETIME_FORMAT_TIMESTAMP),
            'status' => $this->status?->value
        ];
    }
}
