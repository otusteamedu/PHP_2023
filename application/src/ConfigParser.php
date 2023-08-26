<?php

declare(strict_types=1);

namespace Gesparo\Hw;

class ConfigParser
{
    private string $pathToConfigFile;

    public function __construct(string $pathToConfigFile)
    {
        $this->pathToConfigFile = $pathToConfigFile;
    }

    public function parse(): array
    {
        $file = $this->openFile();
        $result = [];

        while (!feof($file)) {
            $line = fgets($file);

            if ($line === false) {
                throw new \RuntimeException("Cannot get line of text from file '$this->pathToConfigFile'");
            }

            if ($line === '') {
                continue;
            }

            [$property, $value] = explode('=', $line);

            if ($property === null || $property === '') {
                throw new \RuntimeException("Cannot read property from the line '$line' in file '$this->pathToConfigFile'");
            }

            $result[$property] = $value;
        }

        fclose($file);

        return $result;
    }

    private function openFile()
    {
        if (is_dir($this->pathToConfigFile)) {
            throw new \InvalidArgumentException("Path '$this->pathToConfigFile' is a directory");
        }

        if (!file_exists($this->pathToConfigFile)) {
            throw new \RuntimeException("File '$this->pathToConfigFile' does not exist");
        }

        if (!is_readable($this->pathToConfigFile)) {
            throw new \RuntimeException("File '$this->pathToConfigFile' is not readable");
        }

        $file = fopen($this->pathToConfigFile, 'rb');

        if ($file === false) {
            throw new \RuntimeException("Cannot open file '$this->pathToConfigFile'");
        }

        return $file;
    }
}