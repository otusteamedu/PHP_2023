<?php

namespace App\OldCode\Services\Order;

use App\OldCode\Models\Order;
use Illuminate\Support\Arr;

class CreateOrderService
{
    public function run (array $args) : int
    {
         $order = new Order();
         $order->email = Arr::get($args, 'email');
         $order->title = Arr::get($args, 'title');
         $order->description = Arr::get($args, 'description');
         $order->save();

         return $order->id;
    }

    public static function rules(array $args = [])
    {
        return [
            'email' => ['required', 'string', 'email'],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
