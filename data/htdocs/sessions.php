<?php

require __DIR__ . '/_const.php';
$sessions = [];

$i = 0;
$sql = 'TRUNCATE TABLE tickets, sessions;' . PHP_EOL;
$sql .= 'INSERT INTO sessions (id, film_id, hall_id, date, during_time) VALUES ' . PHP_EOL;

for ($hall = 1; $hall <= $hallsCount; $hall++) {
    $date = strtotime($dateFrom);
    while (true) {
        $date += $seanceDuration;
        $i++;
        $film = rand(1, $filmsCount);
        $sql .= " ({$i}, {$film}, {$hall}, '" . date('Y-m-d', $date) . "', '[" . date('Y-m-d H:i:s', $date) . "," . date('Y-m-d H:i:s', $date + $seanceDuration - 1) . ")')," . PHP_EOL;

        if ($i >= $sessionCount) {
            break;
        }
    }
}
$sql = substr($sql, 0, -2) . ';';
file_put_contents('./sessions.sql', $sql);
