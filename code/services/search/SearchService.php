<?php

/**
 * Абстрактный класс сервиса поиска
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

namespace Amedvedev\code\services\search;

abstract class SearchService
{
    /**
     * Стратегия выбора метода
     * @param array $data
     * @param int $argc
     * @return void
     */
    public function strategy(array $data, int $argc): void
    {
        var_dump($data);
    }

    /**
     * Метод инициализации сервиса поиска
     * @return void
     */
    public function init(): void
    {
        echo 'init method';
    }

    /**
     * Метод поиска
     * @return void
     */
    public function search(): void
    {
        echo 'search method';
    }

    /**
     * Справка по коммандам
     * @return void
     */
    public function help(): void
    {
        echo 'help method';
    }

    /**
     * Метод проверки работоспособности сервиса поиска
     * @return void
     */
    public function check(): void
    {
        echo 'check method';
    }
}
