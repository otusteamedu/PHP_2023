<?php

namespace Shabanov\Otusphp\Redis;

class RedisDataRender
{
    private array $data;
    public function __construct(array $arData)
    {
        $this->data = $arData;
    }

    public function show(): void
    {
        if (!empty($this->data)) {
            foreach($this->data as $k=>$v) {
                echo 'Под ваши параметры подоходит событие ' . $k . ' с релевантностью ' . $v . PHP_EOL;
            }
        }
    }
}
