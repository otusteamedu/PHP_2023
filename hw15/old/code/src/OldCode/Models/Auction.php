<?php

namespace old\code\src\OldCode\Models;

/**
 * Illuminate\Database\Eloquent
 */
class Auction extends ModelEloquent
{
    public ?int $id;
    public string $title;
    public int $step;
}
