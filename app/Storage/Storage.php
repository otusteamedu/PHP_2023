<?php

namespace app\Storage;

interface Storage
{
    public function add($priority, $conditions, $event);
    public function clear();
    public function get($params);
}
