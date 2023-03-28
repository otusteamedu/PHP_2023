<?php

declare(strict_types=1);

namespace Aporivaev\Hw05;

class Hw05
{
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    public function historyGet(): array
    {
        return $_SESSION['history'] ?? [];
    }
    public function historyAdd($string): void
    {
        $history = $_SESSION['history'] ?? [];
        $history[] = $string;
        $_SESSION['history'] = $history;
    }

    /**
     * @return array {nginx: string, php: string}
     */
    public function getEnv(): array
    {
        return [
            'nginx' => $_SERVER['NGINX_INSTANCE'] ?? 'unknown',
            'php' => getenv('PHP_FPM_INSTANCE') !== false ? getenv('PHP_FPM_INSTANCE') : 'unknown'
            ];
    }

    public function validate(bool $output = true): bool
    {
        $string = $_POST['string'] ?? '';

        $result = $this->parseString($string);
        $this->historyAdd($string . ' - ' . ($result ? 'ok' : 'err'));

        if ($output) {
            http_response_code($result ? 200 : 400);
            echo($result ? 'всё хорошо' : 'всё плохо');
        }
        return $result;
    }
    private function parseString(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        $charOpen = '(';
        $charClose = ')';
        $count = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === $charOpen) {
                $count++;
            } elseif ($string[$i] === $charClose) {
                    $count--;
            } else {
                return false;
            }

            if ($count < 0) {
                return false;
            }
        }
        return $count === 0;
    }
}
