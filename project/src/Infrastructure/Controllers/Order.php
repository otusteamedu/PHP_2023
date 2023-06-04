<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vp\App\Application\Dto\Data\OrderData;
use Vp\App\Application\QueueNames;

class Order
{
    public function create(Request $request, Application $app): JsonResponse
    {
        $postData = $request->request->all();

        $validator = $app['services.validator']
            ->validate($app['constraint.order']->getConstraints(), $postData);

        if (!$validator->isValid()) {
            return JsonResponse::create(['error' => $validator->getErrors()])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $orderData = new OrderData($postData['productId'], $postData['quantity']);
        $orderResult = $app['useCase.order']->create($orderData);

        if (!$orderResult->isSuccess()) {
            return JsonResponse::create(['error' => $orderResult->getMessage()])
                    ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $queueResult = $app['useCase.queue']->createJob(
            QueueNames::orderHandle->name,
            json_encode(['id' => $orderResult->getId()])
        );

        if (!$queueResult->isSuccess()) {
            return JsonResponse::create(['error' => $queueResult->getMessage()])
                    ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return JsonResponse::create(['id' => $orderResult->getId()]);
    }

    public function getStatus(Request $request, Application $app): JsonResponse
    {
        $orderId = $request->get('id');

        if (!isset($orderId)) {
            return JsonResponse::create(['error' => 'Required id parameter expected'])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $result = $app['useCase.order']->getStatus((int)$orderId);

        if (!$result->isSuccess()) {
            return JsonResponse::create(['error' => $result->getMessage()])
                    ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return JsonResponse::create([
            'orderId' => (int)$orderId,
            'status' => $result->getStatus()
        ]);
    }
}
