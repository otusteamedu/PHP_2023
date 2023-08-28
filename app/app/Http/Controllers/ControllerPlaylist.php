<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistAddRequest;
use App\Http\Requests\PlaylistGetListByUserRequest;
use App\Http\Services\ServicePlaylist;
use Illuminate\Http\JsonResponse;

class ControllerPlaylist extends Controller
{
    private ServicePlaylist $servicePlaylist;

    /**
     * @param ServicePlaylist $servicePlaylist
     */
    public function __construct(ServicePlaylist $servicePlaylist)
    {
        $this->servicePlaylist = $servicePlaylist;
        parent::__construct();
    }

    public function getList(PlaylistGetListByUserRequest $request): JsonResponse
    {
        $userId = (int)$request->get('user_id');
        $this->result = $this->servicePlaylist->getListUserId($userId)->toArray();
        return $this->prepareResult();
    }

    public function add(PlaylistAddRequest $request): JsonResponse
    {
        $this->servicePlaylist->add($request->all());
        return $this->prepareResult();
    }
}
