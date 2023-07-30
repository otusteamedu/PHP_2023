<?php

namespace IilyukDmitryi\App\Storage\Mysql\Entity;

class Event
{
    protected string $id;
    
    protected string $event;
    protected string $priority;
    protected array $params;
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    /**
     * @param string $id
     * @return Event
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }
    
    /**
     * @param string $event
     * @return Event
     */
    public function setEvent(string $event): self
    {
        $this->event = $event;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }
    
    /**
     * @param string $priority
     * @return Event
     */
    public function setPriority(string $priority): self
    {
        $this->priority = $priority;
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
            $params = explode(',', $params);
        }
        $this->params = $params;
        return $this;
    }
}
