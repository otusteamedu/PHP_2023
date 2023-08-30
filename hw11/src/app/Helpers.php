<?php

declare(strict_types=1);

namespace App;

trait Helpers
{
    public function env(string $key = null): bool|string
    {
        $filePath = __DIR__ . '/../.env';

        if (!file_exists($filePath)) {
            echo 'Copy .env.example to .env file and fill in required values.' . PHP_EOL;
            exit;
        }

        if ($key) {
            $handle = fopen($filePath, 'r');
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (strpos($line, '=')) {
                        [$param, $value] = explode('=', $line);

                        if (trim($param) === $key) {
                            return trim($value);
                        }
                    }
                }

                fclose($handle);
            }
        }

        return false;
    }
}
