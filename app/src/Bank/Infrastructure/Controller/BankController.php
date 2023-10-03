<?php

declare(strict_types=1);

namespace App\Bank\Infrastructure\Controller;

use App\Bank\Application\DTO\BankStatementRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BankController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/v1/bank/statement")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param BankStatementRequest $request
     * @return Response
     */
    public function statement(BankStatementRequest $request): Response
    {
        $connection = new AMQPStreamConnection('rabbitmq', '5672', 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('bank', false, true, false, false);

        $msg = new AMQPMessage('Hello World!');
        $channel->basic_publish($msg, '', 'bank');

        $channel->close();
        $connection->close();

        return new JsonResponse(['status' => 'ok', 'message' => 'Request accepted for processing']);
    }

    /**
     * @Rest\Get("/api/v1/rabbitmq/queue")
     * @return Response
     */
    public function queue(): Response
    {
        $connection = new AMQPStreamConnection('rabbitmq', '5672', 'guest', 'guest');
        $channel = $connection->channel();

        $queueName = 'bank';
        $channel->queue_declare($queueName, false, true, false, false);
        $res = $channel->basic_get($queueName);

        $channel->close();
        $connection->close();

        return new JsonResponse($res);
    }
}
