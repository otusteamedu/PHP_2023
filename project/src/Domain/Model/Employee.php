<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int $id
 * @property string $name
 * @property int $position_id
 * @method static where(string $string, string $name)
 */
class Employee extends Eloquent {

    protected $fillable = [
        'name'
    ];
}
