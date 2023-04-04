<?php

declare(strict_types=1);

namespace Twent\Hw13\Database;

final class Repository extends BaseMapper
{
    public function load($entity): BaseMapper
    {
        $entity = ucfirst($entity) . 'Mapper';
        $class = "\\Twent\\Hw13\\Database\\$entity";

        if (! $this->map->hasId($entity)) {
            $this->map->set($entity, new $class($this->connection));

            return $this->map->get($entity);
        }

        return $this->map->get($entity);
    }
}
