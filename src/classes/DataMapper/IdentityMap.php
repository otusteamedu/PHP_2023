<?php

namespace Klobkovsky\App\DataMapper;

class IdentityMap
{
    /**
     * @var \ArrayObject
     */
    protected $recodrs;

    public function __construct()
    {
        $this->recodrs = new \ArrayObject();
    }

    /**
     * @param integer $id
     * @param mixed $object
     */
    public function set($id, $object)
    {
        $this->recodrs[$id] = $object;
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->recodrs[$id]);
    }

    /**
     * @param integer $id
     * @throws OutOfBoundsException
     * @return object
     */
    public function get($id)
    {
        if (false === $this->has($id)) {
            throw new OutOfBoundsException();
        }

        return $this->recodrs[$id];
    }
}
