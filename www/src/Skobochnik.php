<?php

namespace Nalofree\WsTest;

use Exception;
use Memcached;

class Skobochnik
{
    private string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    private function getCache($key)
    {
        if (!$key) {
            return ['exist' => false, 'result' => null];
        }
        $m = new Memcached();
        $m->addServer('memcached', 11211);
        if (!($result = $m->get($key))) {
            if ($m->getResultCode() === Memcached::RES_NOTFOUND) {
                return ['exist' => false, 'result' => null];
            } else {
                throw new Exception('Сломался кэш', 500);
            }
        } else {
            return ['exist' => true, 'result' => $result];
        }
    }

    private function setCache($key, $value)
    {
        $m = new Memcached();
        $m->addServer('memcached', 11211);
        $m->set($key, $value);
    }

    /**
     * @throws Exception
     */
    public function check(): string
    {
        // Пройдем по символам во всей строке, будем складывать в массив открывающую скобку,
        // затем если встретилась закрывающая, то убираем из буфера открывающую. Если на последней итерации массив
        // открывающих скобок пуст, то выражение корректно.
        // Важные условия, что открывающие скобки были и закрывающие скобки тоже были, если хотябы одного типа небыло,
        // то выражение автоматически неверно. Оно должно проверяться для любого вида скобок, их четыре.

        // Сначала уберем из выражения не скобки
        $s_string = preg_replace('/[^\(\)\{\}\[\]\<\>]/', '', $this->string);

        // Сходим в кэш и посмотрим обрабатывали ли мы такую строку. Если да, от результат отдадим из кэша.
        $cache = $this->getCache($s_string);
        if ($cache['exist']) {
            return $cache['result'];
        }

        if (!strlen($s_string)) {
            return false; //Если строка пуста, то и проверять нечего.
        }
        $stacks = [
            '(' => [],
            '[' => [],
            '{' => [],
            '<' => []
        ];
        $mirror_sk = [
            ')' => '(',
            ']' => '[',
            '}' => '{',
            '>' => '<'
        ];
        $i = 0; // обойдем строку
        while ($i < strlen($s_string)) {
            // Проверим какого типа эта скобка
            if (array_key_exists($s_string[$i], $stacks)) {
                array_push($stacks[$s_string[$i]], $s_string[$i]);
            } else {
                $sk = isset($stacks[$mirror_sk[$s_string[$i]]]) ? array_pop($stacks[$mirror_sk[$s_string[$i]]]) : null;
                if ($sk === null) {
                    // Как только для закрывающей скобки не нашлось открывающей мы сломаемся.
                    $this->setCache($s_string, false);
                    return false;
                }
            }
            $i++;
        }
        // Если хотябы один из стеков не пустой, то скобки поставлены неверно
        if (!empty($stacks['(']) || !empty($stacks['[']) || !empty($stacks['{']) || !empty($stacks['<'])) {
            $this->setCache($s_string, false);
            return false;
        }
        $this->setCache($s_string, true);
        return true;
    }
}
