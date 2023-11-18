<?php

namespace src\application\api;

use src\infrastructure\portAdapter\ControllerToRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\application\notify\NotifyService;
use src\application\portAdapter\GetValueInterface;
use src\config\ParameterNames as Attrs;
use src\infrastructure\log\LogInterface;
use src\infrastructure\repository\Repository;

class EventController
{
    private GetValueInterface $requestService;
    private LogInterface $log;

    public function __construct(
        GetValueInterface $requestService,
        LogInterface $log
    ) {
        $this->requestService = $requestService;
        $this->log = $log;
    }

    public function add(Request $request, Response $response): Response
    {
        $event = $this->requestService->getValue($request, Attrs::EVENT, '');
        $user  = $this->requestService->getValue($request, Attrs::USER_ATTRIBUTE, '33');
        $this->log->info('');
        $this->log->info('add-event:' . $event);
        $this->log->info('for-user:' . $user);

        /** @var Repository $repository */
        $repository = $this->requestService->getValue($request, Attrs::REPOSITORY_ATTRIBUTE);

        try {
            $subscribers = ControllerToRepository::getSubscribers($repository, $user, $event);
        } catch (\Exception $exception) {
            $this->log->error('user:' . $user . ' event:' . $event . 'Exception:' . get_class($exception));
            return JsonResponse::use(
                $response,
                [
                    'success' => false,
                    'errors' => [
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                    ]
                ]
            )->error()->getResponse();
        }

        $this->log->info('subscribers-count:' . count($subscribers));

        /** @var NotifyService $service */
        $service = $this->requestService->getValue($request, Attrs::NOTIFY_SERVICE_ATTRIBUTE);
        $service->notify($subscribers);

        $this->log->info('ok');

        return JsonResponse::use($response)->success()->getResponse();
    }

    public function addSubscriberByEvent(Request $request, Response $response): Response
    {
        $event      = $this->requestService->getValue($request, Attrs::EVENT, '');
        $subscriber = $this->requestService->getValue($request, Attrs::SUBSCRIBER, '');
        $user       = $this->requestService->getValue($request, Attrs::USER_ATTRIBUTE, '33');

        /** @var Repository $repository */
        $repository = $this->requestService->getValue($request, Attrs::REPOSITORY_ATTRIBUTE);
        try {
            ControllerToRepository::addSubscriberByEventForUser($repository, $user, $event, $subscriber);

            return JsonResponse::use($response)->success()->getResponse();
        } catch (\Exception $exception) {
            return JsonResponse::use(
                $response,
                [
                    'success' => false,
                    'errors' => [
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                    ]
                ]
            )->error()->getResponse();
        }
    }
}
