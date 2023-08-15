<?php
/** Точка входа в приложение
 * @file
 * @author Alex Medvedev <alex150rus@outlook.com>
 * @category Fun
 * @php ^8.1
 * @package No
 * @licence no
 * @link no
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Amedvedev\FirstPackage\MyWords;

$myWords = new MyWords();

echo $myWords->getMyWords()[0];
