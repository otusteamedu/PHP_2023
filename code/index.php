<?php
/**
 * Точка входа в приложение
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @licence  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version  GIT: @1.0.0@
 * @link     https://github.com/Alex150Rus
 * @license  GNU Public License
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Amedvedev\FirstPackage\MyWords;

$myWords = new MyWords();

echo $myWords->getMyWords()[0];
