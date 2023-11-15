<?php

declare(strict_types=1);

namespace Gesparo\HW\Controller;

use Gesparo\HW\Sender\SMSSender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SMSController implements ControllerInterface
{
    private Request $request;
    private SMSSender $sender;

    public function __construct(SMSSender $sender, Request $request)
    {
        $this->request = $request;
        $this->sender = $sender;
    }

    public function run(): Response
    {
        $this->sender->sendMessage($this->request->get('phone'), $this->request->get('message'));

        return new Response('', Response::HTTP_CREATED);
    }
}
