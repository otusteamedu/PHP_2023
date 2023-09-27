<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Entity;

class Event
{
    protected string $uuid;

    protected bool $done;

    protected array $params;


    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return Event
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $params
     */
    public function setParams(array|string $params): self
    {
        if (!is_array($params)) {
            $params = json_decode($params, true);
        }
        $this->params = $params;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->done;
    }

    /**
     * @param bool $done
     * @return Event
     */
    public function setDone(bool $done): Event
    {
        $this->done = $done;
        return $this;
    }
}

