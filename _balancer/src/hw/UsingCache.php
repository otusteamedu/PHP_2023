<?php

namespace Ndybnov\Hw04\hw;

use NdybnovHw03\CnfRead\ConfigStorage;

class UsingCache
{
    public function run(): void
    {
        $getId = $_GET['id'] ?? null;

        if ($getId) {
            echo \session_id($getId);
        }
        \session_start();

        $this->printMultiLine([
            '<br>',
            'Привет, Otus!!!',
            '<br>',
            '<br>',
            'Time: ' . \date('Y-m-d H:i:s'),
            '<br>',
            '<br>',
        ]);

        $configStorage = (new ConfigStorage())->fromDotEnvFile([__DIR__, '..', '.env']);

        $list = $configStorage->get('LIST_MEMCACHE_SERVERS', '');
        $listStrings = \explode(',', $list);
        $listServers = [];
        foreach ($listStrings as $itemString) {
            $listServers[] = \explode(':', $itemString);
        }

        $memcached = new \Memcached();
        $isAdded = $memcached->addServers($listServers);

        $this->printMultiLine([
            '<br>',
            'MemcacheServers - ',
            $isAdded ? 'was add' : 'was not add',
            '<br>',
            '<br>',
        ]);

        $myKey = 'uuid-key';
        $memcached->set($myKey, 'memcached-correct-worked', 10);

        $memcachedValue = $memcached->get($myKey);
        $this->printMultiLine([
            'memcachedValue: ',
            \var_export($memcachedValue, true),
            '<br>',
            '<br>',
        ]);

        $hostName = $_SERVER['HOSTNAME'];
        $this->printMultiLine([
            '<br>',
            'Запрос обработал контейнер(hostname): ' . $hostName,
            '<br>',
            '<br>',
        ]);

        $this->printMultiLine([
            'session_id: ',
             \session_id(),
            '<br>',
            '<br>',
        ]);

        $this->printMultiLine([
            '<br>',
            'PHP_Version: ' . PHP_VERSION,
            '<br>',
            '<br>',
        ]);

        $containers = $_SESSION['hist'] ?? [];
        $containers[$hostName] = isset($containers[$hostName]) ? $containers[$hostName] + 1 : 1;
        $_SESSION['hist'] = $containers;

        $this->printMultiLine([
            '<br>',
            'SESSION:',
            '<br>',
            \var_export($_SESSION, true),
            '<br>'
        ]);

        \session_write_close();
    }

    private function printMultiLine(array $lines): void
    {
        foreach ($lines as $line) {
            echo $line;
        }
    }
}
