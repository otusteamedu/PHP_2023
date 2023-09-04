<?php

/**
 * Описание класса
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

use Memcached;

class MemcachedPresenter
{
    public function render()
    {
        $memcached = new Memcached;
        $memcached->addServer("memcached-otus", 11211);
        $memcached->add('host', $_SERVER['HOSTNAME']);
        return 'Хост закешированный ' . $memcached->get('host') . '. Хост реальный: ' . $_SERVER['HOSTNAME'] . '<br>';
    }
}