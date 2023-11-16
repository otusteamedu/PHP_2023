<?php

namespace src\api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\fabric\IoCEvent;
use src\fabric\IoCSubscriber;
use src\fabric\IoCUser;
use src\log\Log;
use src\notify\NotifyService;
use src\repository\Repository;

class EventController
{
    public function add(Request $request, Response $response): Response
    {
        $stringParameter = new StringParameterFromRequest();
        $event = $stringParameter->getValue($request, 'event', '');
        $user  = $stringParameter->getValue($request, 'user', '33');
        Log::info('');
        Log::info('add-event:' . $event);
        Log::info('for-user:' . $user);

        /** @var Repository $repository */
        $repository = $stringParameter->getValue($request, 'Repository');
        $subscribers = $repository->getSubscribersForUser(
            IoCEvent::create($event),
            IoCUser::create($user)
        );
        Log::info('subscribers-count:' . count($subscribers));

        /** @var NotifyService $service */
        $service = $stringParameter->getValue($request, 'NotifyService');
        $service->notify($subscribers);

        Log::info('ok');

        return $response->withStatus(200);
    }

    public function addSubscriberByEvent(Request $request, Response $response): Response
    {
        $stringParameter = new StringParameterFromRequest();
        $event      = $stringParameter->getValue($request, 'event', '');
        $subscriber = $stringParameter->getValue($request, 'subscriber', '');
        $user       = $stringParameter->getValue($request, 'user', '33');

        /** @var Repository $repository */
        $repository = $stringParameter->getValue($request, 'Repository');
        $repository->addSubscriberByEventForUser(
            IoCSubscriber::create($subscriber),
            IoCEvent::create($event),
            IoCUser::create($user)
        );

        return $response->withStatus(200);
    }
}
