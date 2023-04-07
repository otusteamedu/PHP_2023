<?php

use Builov\Cinema\DB;
use Builov\Cinema\model\Seat;

require __DIR__ . '/vendor/autoload.php';

try {
//    DB::init();
    DB::connect();
} catch (PDOException $e) {
    echo $e->getMessage();
}

$seat = new Seat();

if ($seat->get(1316)) {
    echo $seat->seat_number;
} else {
    echo 'не найдено';
}

$seat->delete();




//echo $seat->create(1, 30, 32, 3);


//$session_id = 40;
//
//$map = Seat::getSeatsMap($session_id);
//
//require_once('./src/tmpl/hall_map.php');


