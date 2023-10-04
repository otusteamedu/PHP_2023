<?php

/**
 * Класс представления данных в консольном приложении
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

namespace Amedvedev\code\presenters;

class ConsolePresenter
{
    /**
     * @param array $data
     * @return void
     */
    public function showTextTable(array $data): void
    {
        foreach ($data as $hit) {
            echo PHP_EOL . $hit['_source']['category'] . ' - ' . $hit['_source']['title'] . ' - '
                . $hit['_source']['price'] . PHP_EOL;
        }
    }
}
