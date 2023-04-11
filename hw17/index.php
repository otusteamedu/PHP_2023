<?php

use Builov\Cinema\DB;
use Builov\Cinema\model\Seat;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

try {
    DB::connect();
} catch (PDOException $e) {
    echo $e->getMessage();
}

$seat = new Seat();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            /** создание новой записи */
            echo $seat->create(1, 30, 32, 3);
            break;
        case 'update':
            /** редактирование */
            if ($seat->load(1314)) {
                $seat->seat_number = 33;
                echo $seat->save();
            } else {
                echo 'Не найдено.';
            }
            break;
        case 'delete':
            /** удаление */
            if ($id = $seat->delete(1311)) {
                echo $id;
            } else {
                echo 'Не найдено.';
            }
            break;
        case 'price':
            /** получение цены места */
            $seat->load(1);
            echo $seat->price;
            break;
        case 'hall':
            /** получение названия зала */
            $seat->load(1);
            echo $seat->hall;
            break;
    }
} else {

    /** вывод карты зала */
    $session_id = 40;
    $map = Seat::getSeatsMap($session_id);
    require_once('./src/tmpl/hall_map.php');

}
