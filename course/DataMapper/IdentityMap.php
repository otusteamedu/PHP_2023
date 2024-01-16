<?php

namespace DataMapper;

class IdentityMap
{
    private $identityMap = [];

    public function add($id, $object) {
        $this->identityMap[$id] = $object;
    }

    public function get($id) {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        return null;
    }
}