<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public const STATUS_IN_PROGRESS = 'In progress';
    public const STATUS_COMPLETED = 'Completed';
    public const STATUS_FAILED = 'Failed';

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'status'];
}
