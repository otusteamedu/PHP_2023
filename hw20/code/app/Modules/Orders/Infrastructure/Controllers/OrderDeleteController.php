<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Controllers;

use App\Lumen\Http\Controllers\Controller;

class OrderDeleteController extends Controller
{
    public function run()
    {
        return response()->json(null, 204);
    }
}
