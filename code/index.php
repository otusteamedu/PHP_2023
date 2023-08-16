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

use Amedvedev\FirstPackage\MyWords;

$myWords = new MyWords();

echo $myWords->getMyWords()[0];
