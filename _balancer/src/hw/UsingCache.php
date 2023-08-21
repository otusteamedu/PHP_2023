<?php

namespace Ndybnov\Hw04\hw;

use NdybnovHw03\CnfRead\ConfigStorage;

class UsingCache
{
    public function run()
    {
        $getId = $_GET['id'] ?? null;

        if ($getId) {
            echo \session_id($getId);
        }
        \session_start();


        echo '<br>';
        echo 'Привет, Otus!!!';
        echo '<br>';
        echo '<br>';

        echo 'Time: ' . \date('Y-m-d H:i:s');
        echo '<br>';
        echo '<br>';

        $configStorage = (new ConfigStorage())->fromDotEnvFile([__DIR__, '..', '.env']);

        $list = $configStorage->get('LIST_MEMCACHE_SERVERS', '');
        $listStrings = \explode(',', $list);
        $listServers = [];
        foreach ($listStrings as $itemString) {
            $listServers[] = \explode(':', $itemString);
        }

        $memcached = new \Memcached();
        $isAdded = $memcached->addServers($listServers);


        echo '<br>';
        echo 'MemcacheServers - ';
        echo $isAdded ? 'was add' : 'was not add';
        echo '<br>';
        echo '<br>';

        $myKey = 'uuid-key';
        $memcached->set($myKey, 'memcached-correct-worked', 10);

        $memcachedValue = $memcached->get($myKey);
        echo 'memcachedValue: ';
        \var_dump($memcachedValue);
        echo '<br>';
        echo '<br>';


        echo '<br>';
        $hostName = $_SERVER['HOSTNAME'];
        echo 'Запрос обработал контейнер(hostname): ' . $hostName;
        echo '<br>';
        echo '<br>';


        echo 'session_id: ';
        echo \session_id();
        echo '<br>';
        echo '<br>';


        echo '<br>';
        echo 'PHP_Version: ' . PHP_VERSION;
        echo '<br>';
        echo '<br>';


        $containers = $_SESSION['hist'] ?? [];
        $containers[$hostName] = isset($containers[$hostName]) ? $containers[$hostName] + 1 : 1;
        $_SESSION['hist'] = $containers;


        echo '<br>';
        echo 'SESSION:';
        echo '<br>';
        \var_dump($_SESSION);
        echo '<br>';

        \session_write_close();
    }
}
