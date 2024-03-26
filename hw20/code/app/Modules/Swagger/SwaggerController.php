<?php

declare(strict_types=1);

namespace App\Modules\Swagger;

use App\Lumen\Http\Controllers\Controller;

class SwaggerController extends Controller
{
    public function apiDocs()
    {
        $filePath = public_path('swagger/swagger.json');
        return response()->json(json_decode(file_get_contents($filePath), true));
    }
}
