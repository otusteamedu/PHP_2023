<?php

declare(strict_types=1);

namespace AYamaliev\hw12\Application\Dto;

class EventDto
{
    private int $priority;
    private string $event;
    private ?string $param1 = null;
    private ?string $param2 = null;

    public function __construct(array $arguments)
    {
        foreach ($arguments as $argument) {
            $_array = explode('=', $argument);

            if (count($_array) < 2) {
                continue;
            }

            [$argumentName, $argumentValue] = explode('=', $argument);

            switch ($argumentName) {
                case '--priority':
                    $this->priority = (int)$argumentValue;
                    break;
                case '--event':
                    $this->event = $argumentValue;
                    break;
                case '--param1':
                    $this->param1 = $argumentValue;
                    break;
                case '--param2':
                    $this->param2 = $argumentValue;
                    break;
            }
        }
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getParam1(): ?string
    {
        return $this->param1;
    }

    /**
     * @return string
     */
    public function getParam2(): ?string
    {
        return $this->param2;
    }
}
