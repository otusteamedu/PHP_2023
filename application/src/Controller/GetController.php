<?php

declare(strict_types=1);

namespace Gesparo\HW\Controller;

use Gesparo\HW\Request\GetRequest;
use Gesparo\HW\Service\GetService;
use Gesparo\HW\Storage\BaseStorageFacade;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetController implements ControllerInterface
{
    private Request $request;
    private BaseStorageFacade $storageFacade;

    public function __construct(Request $request, BaseStorageFacade $storageFacade)
    {
        $this->request = $request;
        $this->storageFacade = $storageFacade;
    }


    /**
     * @return Response
     * @throws \JsonException
     */
    public function run(): Response
    {
        $conditions = (new GetRequest($this->request))->getConditions();

        $event = (new GetService($conditions, $this->storageFacade))->get();

        if ($event === null) {
            return new JsonResponse([
                'event' => null,
            ]);
        }

        return new JsonResponse([
            'event' => [
                'priority' => $event->getPriority(),
                'conditions' => $event->getConditions(),
                'event' => $event->getEvent(),
            ],
        ]);
    }
}