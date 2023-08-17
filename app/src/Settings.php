<?php
declare(strict_types=1);

namespace Root\App;

class Settings
{
    private array $settings;

    /**
     * @throws AppException
     */
    public function __construct(string $filename)
    {
        $fromIni = parse_ini_file($filename, true);
        if (!is_array($fromIni) || empty($fromIni)) {
            throw new AppException('Empty config');
        }
        $this->settings = $fromIni;
    }

    public function get(string $key = ''): mixed
    {
        return (empty($key)) ? $this->settings : ($this->settings[$key] ?? null);
    }
}