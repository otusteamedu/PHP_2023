<?php

declare(strict_types=1);

namespace Art\Code\ConfigService;

use RuntimeException;

class ConfigDefinition
{
    public function __construct(private string $config_file)
    {
        if (!is_file($config_file)) {
            throw new RuntimeException('No config file provided with ' . $this->config_file);
        }
    }

    public function getOptions(): array
    {
        $options = parse_ini_file($this->config_file, true);

        if ($options === false) {
            throw new RuntimeException('An error occurred while processing ' . $this->config_file);
        }

        return $options;
    }
}
