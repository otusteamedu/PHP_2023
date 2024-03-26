<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;

class OrderInfoController extends Controller
{
    public function run()
    {
        return response()->json(['message' => 'Orders info'], 200);
    }
}
