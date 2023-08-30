<?php
/**
 * Точка входа в приложение
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Amedvedev\code\helpers\BracketsHelper;

if (!empty($_POST)) {
    $bracketsHelper = new BracketsHelper();
    $string = $_POST['string'] ?? '';

    $result = $bracketsHelper->handle($_POST);
    if(!$result) {
        header('HTTP/1.1 400 Bad Request', true, 400);
    }
    echo $result ? '<span style="color:green">Строка со скобками верна' . $string . '</span>' :
        '<span style="color:red">Строка со скобками не верна: </span>' . $string . '<br>';
}

echo '<form method="POST"><input style="width: 199px" name="string" value="(()()()()))((((()()()))(()()()(((()))))))">' .
    '<p><button>Отправить</button></p></form>';

$memcached = new Memcached;
$memcached->addServer("memcached-otus", 11211);
$result = $memcached->add('host', $_SERVER['HOSTNAME']);
echo $memcached->get('host') . '<br>';

echo $_SERVER['HOSTNAME'];

var_dump($_SERVER);



