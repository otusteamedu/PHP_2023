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

namespace Amedvedev\code\applications\elastic\services\search;

abstract class SearchService
{
    /**
     * Стратегия выбора метода
     * @param array $data
     * @param int $argc
     * @return void
     */
    abstract public function strategy(array $data, int $argc): void;

    /**
     * Метод инициализации сервиса поиска
     * @return void
     */
    abstract public function init(): void;

    /**
     * Метод поиска
     * @return void
     */
    abstract public function search(): void;

    /**
     * Справка по коммандам
     * @return void
     */
    abstract public function help(): void;

    /**
     * Метод проверки работоспособности сервиса поиска
     * @return void
     */
    abstract public function check(): void;
}
