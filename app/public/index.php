<?php

declare(strict_types=1);

session_start();

if (!array_key_exists('valid_test_count', $_SESSION)) {
    $_SESSION['valid_test_count'] = 0;
}

if (!array_key_exists('invalid_test_count', $_SESSION)) {
    $_SESSION['invalid_test_count'] = 0;
}

$container = $_SERVER['HOSTNAME'];
$validTestCount = $_SESSION['valid_test_count'];
$invalidTestCount = $_SESSION['invalid_test_count'];
$string = '';
$isValidString = false;
$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!array_key_exists('string', $_POST) || 0 === mb_strlen($_POST['string'])) {
            throw new Exception('Строка не указана.');
        }

        $string = $_POST['string'];
        $openedCount = 0;
        $closedCount = 0;

        for ($i = 0; $i < mb_strlen($string); $i++) {
            $char = mb_substr($string, $i, 1);

            if ('(' === $char) {
                $openedCount++;
            }

            if (')' === $char) {
                $closedCount++;
            }

            if ($closedCount > $openedCount) {
                throw new Exception('Проверка не пройдена.');
            }
        }

        if ($closedCount !== $openedCount) {
            throw new Exception('Проверка не пройдена.');
        }

        $isValidString = true;
    } catch (Exception $exception) {
        $invalidTestCount++;
        $_SESSION['invalid_test_count'] = $invalidTestCount;

        header('HTTP/1.1 400 Bad Request');
        $message = $exception->getMessage();
    }

    if ($isValidString) {
        $validTestCount++;
        $_SESSION['valid_test_count'] = $validTestCount;

        header('HTTP/1.1 200 Ok');
        $message = 'Проверка пройдена.';
    }
}

require dirname(__DIR__) . '/template.php';
