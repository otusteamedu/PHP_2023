<?php

namespace Yakovgulyuta\Hw13\Entity;

use Yakovgulyuta\Hw13\Core\Database\ActiveRecord\Model;

class Session extends Model
{
 /**
  * @var string
  */
    public const TABLE_NAME = 'session';

    public int $id;

    public int $cinema_id;

    public string $start;
}
