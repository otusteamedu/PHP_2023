<?php
require __DIR__ . '/_const.php';

$sql = 'TRUNCATE TABLE tickets;' . PHP_EOL;
$sql .= 'INSERT INTO tickets (session_id, seat_id, customer_id, sale_price) VALUES ' . PHP_EOL;

$seatsCount = $rowsCount * $seatsPerRowCount;
for ($i = 1; $i <= $sessionCount; $i++) {
    for($seat = 1; $seat <= $seatsCount; $seat++) {
        if(rand(0, 100) > 50) {
            $customer = rand(1, $customersCount);
            $price = rand(900, 1000);
            $sql .= "({$i}, {$seat}, {$customer}, {$price}), " . PHP_EOL;
        }
    }
}
$sql = substr($sql, 0, -3) . ';';
file_put_contents('./tickets.sql', $sql);