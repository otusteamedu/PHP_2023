<?php

namespace Yakovgulyuta\Hw13\Entity;

use Yakovgulyuta\Hw13\Core\Database\ActiveRecord\Model;

class Cinema extends Model
{
 /**
  * @var string
  */
    public const TABLE_NAME = 'cinema';

    public int $id;

    public string $name;

    /**
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSessions(): array|null
    {
        return Session::findByField('cinema_id', $this->id);
    }
}
