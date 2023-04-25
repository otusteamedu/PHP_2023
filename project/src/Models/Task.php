<?php

declare(strict_types=1);

namespace Vp\App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int $id
 * @property string $title
 * @method static where(string $string, string $title)
 * @method static find(int $taskId)
 */
class Task extends Eloquent {

    protected $fillable = [
        'title'
    ];
}
