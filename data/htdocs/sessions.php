<?php
ini_set('display_errors', true);

$host='postgres';
$db = $_ENV['POSTGRES_DB'];
$username = $_ENV['POSTGRES_USER'];
$password = $_ENV['POSTGRES_PASSWORD'];


# Создаем соединение с базой PostgreSQL с указанными выше параметрами
$dbconn = pg_connect("host=$host port=5432 dbname=$db user=$username password=$password");

if (!$dbconn) {
    die('Could not connect');
}
else {
    echo("Connected to local DB");
}

$strStartDate = '2023-01-01 00:00:00';
$strEndDate = '2023-01-30 00:00:00';

$startDateTime = new DateTime($strStartDate);
$endDateTime = new DateTime($strEndDate);
$sql = 'TRUNCATE TABLE tickets CASCADE; TRUNCATE TABLE sessions CASCADE';
pg_query($dbconn, $sql);
unlink('./f.sql');

$i = 0;
while (true) {
    $r = '';
    $startDateTime->setTimestamp($startDateTime->getTimestamp() + (60 * 60 * 3));

    if($startDateTime->getTimestamp() > $endDateTime->getTimestamp()) {
        break;
    }

    $filmId = rand(1,10);
    for ($hall = 1; $hall <= 4; $hall++) {
        $i++;
        $duringTime = clone $startDateTime;
        $duringTime->setTimestamp($duringTime->getTimestamp() + (60 * 60 * 3) - 1);

        $sql = "INSERT INTO sessions(id, date, during_time, hall_id, film_id) VALUES (" . $i . ", '" . $startDateTime->format('Y-m-d') . "', '[" . $startDateTime->format('Y-m-d H:i:s') . ", " . $duringTime->format('Y-m-d H:i:s') . "]', " . $hall . ", " . $filmId . ");\n";
        $r .= $sql;
        pg_query($dbconn, $sql);

        $seatsCount = rand(6, 16);
        $arSeats = [];
        while($seatsCount > count($arSeats)) {
            $arSeats[] = rand(1, 16);
            $arSeats = array_unique($arSeats);
        }

        $arCustomers = [];
        while($seatsCount > count($arCustomers)) {
            $arCustomers[$arSeats[count($arCustomers)]] = rand(1, 100);
            $arCustomers = array_unique($arCustomers);
        }

        foreach ($arCustomers as $seatNumber => $customerID) {
            $sql = "INSERT INTO tickets(session_id, seat_id, customer_id, sale_price) VALUES (" . $i . ", " . $seatNumber . ", " . $customerID . ", 1000);\n";
            $r .= $sql;

            pg_query($dbconn, $sql);
        }
    }

    file_put_contents('./f.sql', $r, FILE_APPEND);
}
