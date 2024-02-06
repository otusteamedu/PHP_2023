<?php

namespace old\code\src\OldCode\Models;

use old\code\src\OldCode\Models\ModelEloquent;

/**
 * Illuminate\Database\Eloquent
 */
class Auction extends ModelEloquent
{
    public ?int $id;
    public string $title;
    public int $step;
}
