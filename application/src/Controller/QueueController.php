<?php

declare(strict_types=1);

namespace Gesparo\HW\Controller;

use Gesparo\HW\Storage\StoreInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QueueController implements ControllerInterface
{
    private StoreInterface $store;

    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
    }

    public function run(): Response
    {
        $storeElements = $this->store->getAll();
        $result = [];

        foreach ($storeElements as $storeElement) {
            $result[] = [
                'phone' => $storeElement->getPhone(),
                'message' => $storeElement->getMessage(),
            ];
        }

        return new JsonResponse(['queue' => $result], Response::HTTP_OK);
    }
}
