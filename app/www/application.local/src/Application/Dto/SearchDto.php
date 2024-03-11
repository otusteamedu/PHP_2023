<?php

declare(strict_types=1);

namespace AYamaliev\hw12\Application\Dto;

class SearchDto
{
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
