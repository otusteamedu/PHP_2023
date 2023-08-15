<?php
/**
 * @file
 * Точка входа в приложение
 * @author Alex150rus
 * @category fun
 * @php ^8.1
 * @package no
 * @licence no
 * @link no
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Amedvedev\FirstPackage\MyWords;

$myWords = new MyWords();

echo $myWords->getMyWords()[0];
