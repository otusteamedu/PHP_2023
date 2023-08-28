<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberAddRequest;
use App\Http\Services\ServiceSubscriber;
use Illuminate\Http\JsonResponse;

class ControllerSubscriber extends Controller
{
    private ServiceSubscriber $serviceSubscriber;

    /**
     * @param ServiceSubscriber $serviceSubscriber
     */
    public function __construct(ServiceSubscriber $serviceSubscriber)
    {
        $this->serviceSubscriber = $serviceSubscriber;
        parent::__construct();
    }

    public function add(SubscriberAddRequest $request): JsonResponse
    {
        $this->serviceSubscriber->add($request->toArray());
        return $this->prepareResult();
    }

}
