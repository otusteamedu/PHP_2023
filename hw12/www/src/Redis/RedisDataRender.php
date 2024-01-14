<?php

namespace Shabanov\Otusphp\Redis;

class RedisDataRender
{
    private array $data;
    public function __construct(array $arData)
    {
        $this->data = $arData;
    }

    public function show(): string
    {
        $result = '';
        if (!empty($this->data)) {
            foreach($this->data as $k=>$v) {
                $result .= 'Под ваши параметры подоходит событие ' . $k . ' с релевантностью ' . $v . PHP_EOL;
            }
        }
        return $result;
    }
}
