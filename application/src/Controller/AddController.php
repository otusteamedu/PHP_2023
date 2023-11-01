<?php

declare(strict_types=1);

namespace Gesparo\HW\Controller;

use Gesparo\HW\Request\AddRequest;
use Gesparo\HW\Service\AddService;
use Gesparo\HW\Storage\BaseStorageFacade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddController implements ControllerInterface
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
        $events = (new AddRequest($this->request))->getEvents();

        (new AddService($events, $this->storageFacade))->add();

        return new Response('Events added');
    }
}