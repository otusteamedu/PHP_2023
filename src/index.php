<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\App\DB;
use \Klobkovsky\App\DataMapper\ManufacturerMapper;

$br = "<br/>";

try {
    $DB = new DB();
    $manufacturer = new ManufacturerMapper($DB->pdo);

    echo "Добавляем производителя: " . $br;
    $man = $manufacturer->insert([
        'parent_id' => 1,
        'level' => 2,
        'name' => 'BRICHKA',
        'rusname' => 'Бричка',
        'alias' => 'brichka',
    ]);
    echo "<pre>"; var_export($man); echo "</pre>";

    echo "Обновляем производителя: " . $br;
    $man->setRusname('Супербричка');

    if ($manufacturer->update($man)) {
        echo "<pre>"; var_export($man); echo "</pre>";
    }

    echo "Удаляем производителя: " . $br;

    if ($manufacturer->delete($man)) {
        echo "OK". $br;
    }

    $man1 = $manufacturer->findById(2);
    $man2 = $manufacturer->findById(2);

    echo "Производитель. Экземпляр 1: " . $man1->getRusname() . $br;
    echo "Производитель. Экземпляр 2: " . $man2->getRusname() . $br;

    $man1->setRusname('БМВ');
    echo "Замена производителя на БМВ" . $br;

    echo "Производитель. Экземпляр 1: " . $man1->getRusname() . $br;
    echo "Производитель. Экземпляр 2: " . $man2->getRusname() . $br;

    echo "Получение производителей с id = 5,6,7: " . $br;
    echo "<pre>"; var_export($manufacturer->findByIds([5, 6, 7])); echo "</pre>";
} catch (Throwable $e) {
    echo 'Error: ' . $e->getMessage();
}
