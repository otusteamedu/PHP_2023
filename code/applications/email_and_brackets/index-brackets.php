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

use Amedvedev\code\applications\email_and_brackets\BracketsValidatorApp;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $app = new BracketsValidatorApp();
    echo $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
