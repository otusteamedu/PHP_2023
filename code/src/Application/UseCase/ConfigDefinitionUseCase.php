<?php

declare(strict_types=1);

namespace Art\Code\Application\UseCase;

use Art\Code\Application\Contract\ConfigDefinitionInterface;
use RuntimeException;

class ConfigDefinitionUseCase implements ConfigDefinitionInterface
{
    /**
     * @param string $config_file
     */
    public function __construct(private readonly string $config_file)
    {
        if (!is_file($config_file)) {
            throw new RuntimeException('No config file provided with ' . $this->config_file);
        }
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options = parse_ini_file($this->config_file, true);

        if ($options === false) {
            throw new RuntimeException('An error occurred while processing ' . $this->config_file);
        }

        return $options;
    }
}
