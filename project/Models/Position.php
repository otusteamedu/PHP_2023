<?php

declare(strict_types=1);

namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int $id
 * @property string $name
 * @property int $rate
 * @method static where(string $string, string $trim)
 */
class Position extends Eloquent {

    protected $fillable = [
        'name'
    ];
}
