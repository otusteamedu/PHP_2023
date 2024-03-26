<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;

class OrderUpdateController extends Controller
{
    public function run()
    {
        return response()->json(['message' => 'Order updated'], 200);
    }
}
