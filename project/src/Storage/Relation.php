<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use WS\Utils\Collections\Collection;

class Relation
{
    private Collection $relation;
    public function __construct($instance, $foreignKey, $relateId)
    {
        $this->relation = $instance::where($foreignKey, $relateId);
    }

    public function getCollection(): Collection
    {
        return $this->relation;
    }
}
