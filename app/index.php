<?php

declare(strict_types=1);

$mc = new Memcached();

$mc->addServer("memcached", 11211);

echo "Connection to Memcached successfully" . PHP_EOL;

$mc->set("key", "Memcached");

$mc->set("status", "ok");

echo $mc->get("key") . " is " . $mc->get("status") . PHP_EOL;

$string = $_POST['string'] ?? null;

if (!$string) {
    http_response_code(400);
    exit("Parameter must not be empty");
}

$string = preg_replace('/[^\(\)]/', '', $string);

$i = 0;

$opened = 0;

try {
    while ($i < strlen($string)) {

        if ($string[$i] == '(') {
            $opened++;
        }

        if ($string[$i] == ')') {
            $opened--;
        }

        if ($opened < 0) {
            throw new Exception("Invalid string");
        }

        $i++;
    }

    if ($opened != 0) {
        throw new Exception("Invalid string");
    }
} catch (Exception $e) {
    http_response_code(400);
    exit($e->getMessage());
}

echo 'Is ok';
