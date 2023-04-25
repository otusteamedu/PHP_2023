<?php

declare(strict_types=1);

namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int $id
 * @property int $task_id
 * @property int $employee_id
 * @method static where(string $string, string $title)
 * @method static find(int $id)
 */
class Timesheet extends Eloquent {

    protected $fillable = [
        'task_id', 'employee_id', 'start_time', 'end_time'
    ];
}
