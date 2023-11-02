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

use Amedvedev\code\applications\elastic\SearchApp;
use Amedvedev\code\applications\elastic\services\search\ConsoleSearchService;
use Amedvedev\code\config\Config;

require_once __DIR__ . '/../../../vendor/autoload.php';

try {
    Config::init();
    $app = new SearchApp($argv, $argc, new ConsoleSearchService());
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
