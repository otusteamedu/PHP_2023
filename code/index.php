<?php
/**
 * Точка входа в приложение
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package AmedvedevPHP2023Otus
 * @author  Alex Medvedev alex150rus@outlook.com
 * @licence GPL
 * @version GIT: @1.0.0@
 * @link https://github.com/Alex150Rus
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Amedvedev\FirstPackage\MyWords;

$myWords = new MyWords();

echo $myWords->getMyWords()[0];
