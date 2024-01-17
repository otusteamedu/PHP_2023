<?php

declare(strict_types=1);

include_once __DIR__ . "/vendor/autoload.php";

use App\DB;
use App\CarsMapper;

$pdo = DB::init();

$model = new CarsMapper($pdo);

// метод массового получения информации из таблицы, результат которого возвращается в виде коллекции.
$arrayObject = $model->findAll();

foreach ($arrayObject as $value) {
    echo $value->getName() . '<br>';
}
/**
 * Result:
 *  opel
 *  bmw
 *  renault
 */

// паттерн Identity Map
var_dump($model->findById(1) === $model->findById(1));
/**
 * Result:
 *  bool(true)
 */

// паттерн Lazy Load
$car = $model->findById(1);
echo "<pre>";
print_r($car->getModels());
echo "</pre>";
/**
 * Result:
 *  Array
 * (
 *   [0] => Array
 *       (
 *            [id] => 1
 *            [car_id] => 1
 *            [name] => signum
 *        )
 *
 *    [1] => Array
 *        (
 *            [id] => 2
 *            [car_id] => 1
 *            [name] => vectra
 *        )
 *
 *    [2] => Array
 *        (
 *            [id] => 3
 *            [car_id] => 1
 *            [name] => insignia
 *        )
 *
 * )
*/
