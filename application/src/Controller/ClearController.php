<?php

declare(strict_types=1);

namespace Gesparo\HW\Controller;

use Gesparo\HW\Service\ClearService;
use Gesparo\HW\Storage\BaseStorageFacade;
use Symfony\Component\HttpFoundation\Response;

class ClearController implements ControllerInterface
{
    private BaseStorageFacade $storageFacade;

    public function __construct(BaseStorageFacade $storageFacade)
    {
        $this->storageFacade = $storageFacade;
    }

    /**
     * @return Response
     */
    public function run(): Response
    {
        (new ClearService($this->storageFacade))->clear();

        return new Response('Storage cleared');
    }
}