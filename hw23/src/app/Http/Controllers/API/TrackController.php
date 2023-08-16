<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackController
{
    public function showList(Request $request): Collection
    {
        return (new Track())->getList($request->all());
    }

    public function create(Request $request, Track $model): JsonResponse
    {
        $result = $model->create($request->all());

        if (is_int($result)) {
            return response()->json(['success' => true], Response::HTTP_OK);
        }
        return response()->json(['success' => false, 'errors' => $result], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
