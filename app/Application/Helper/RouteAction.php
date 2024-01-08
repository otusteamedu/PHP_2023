<?php

namespace App\Application\Helper;

use App\Application\Action\AddComboMessage\AddComboMessageAction;
use App\Application\Action\ActionInterface;
use App\Application\Action\ClearQueue\ClearQueueAction;
use App\Application\Action\ReadQueueMessages\ReadQueueMessagesAction;
use App\Application\Action\ReadQueueStatusMessage\ReadQueueStatusMessageAction;
use App\Application\DTO\ArgumentsDTO;

class RouteAction
{
    public function get(ArgumentsDTO $arguments): ActionInterface
    {
        $argAction = $arguments->getAction();
        $actions = [
            'add' => AddComboMessageAction::class,
            'get' => ReadQueueMessagesAction::class,
            'clr' => ClearQueueAction::class,

            'read' => ReadQueueStatusMessageAction::class,
        ];

        if (!isset($actions[$argAction])) {
            $msg = 'Error: Unexpected arguments!';
            throw new \RuntimeException($msg);
        }

        return new $actions[$argAction]($arguments);
    }
}
