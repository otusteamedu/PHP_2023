<?php

declare(strict_types=1);

session_start();

$history = $_SESSION['history'] ?? [];
$string = $_POST['string'] ?? '';
$method = $_SERVER['REQUEST_METHOD'] ?? null;

$from = $_SERVER['NGINX_INSTANCE'] ?? 'unknown';
$php = getenv('PHP_FPM_INSTANCE') !== false ? getenv('PHP_FPM_INSTANCE') : 'unknown';

function parseString(string $string): bool
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
        } else {
            if ($string[$i] === $charClose) {
                $count--;
            } else {
                return false;
            }
        }

        if ($count < 0) {
            return false;
        }
    }

    return $count == 0;
}

if ($method === 'POST') {
    $history[] = $string;
    $result = parseString($string);

    http_response_code($result ? 200 : 400);
    echo($result ? 'всё хорошо' : 'всё плохо');
} else {
    echo "NGINX instance - {$from}\n<br>\nPHP instance - {$php}\n<br>\n";
    echo "History:<br>\n<ul>\n";
    foreach ($history as $item) {
        echo "<li>{$item}</li>\n";
    }
    echo "</ul>";
}

$_SESSION['history'] = $history;
