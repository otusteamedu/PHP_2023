<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackAddRequest;
use App\Http\Requests\TrackGetByGenreRequest;
use App\Http\Services\ServiceTrack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerTrack extends Controller
{
    private ServiceTrack $serviceTrack;

    public function __construct(
        ServiceTrack $serviceTrack
    ) {
        parent::__construct();
        $this->serviceTrack = $serviceTrack;
    }

    public function getList(): JsonResponse
    {
        $this->result = $this->serviceTrack->getAll()->toArray();
        return $this->prepareResult();
    }

    public function getByGenre(TrackGetByGenreRequest $request): JsonResponse
    {
        $genre = $request->get('genre');
        $this->result = $this->serviceTrack->getByGenre((int)$genre)->toArray();
        return $this->prepareResult();
    }

    public function add(TrackAddRequest $request): JsonResponse
    {
        $this->serviceTrack->add($request->all());
        return $this->prepareResult();
    }

    public function subscribe(Request $request): JsonResponse
    {
        return $this->prepareResult();
    }
}
