<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'public.orders';
    public $primaryKey = 'uuid';
    public $keyType = 'string';

}
