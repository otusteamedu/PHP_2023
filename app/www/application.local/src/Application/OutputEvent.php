<?php

declare(strict_types=1);

namespace AYamaliev\hw12\Application;

use AYamaliev\hw12\Domain\Entity\Event;

class OutputEvent
{
    public function __invoke(?Event $event): void
    {
        if (!$event) {
            return;
        }

        echo '|';
        echo " {$event->getEvent()} | ";
        echo " {$event->getPriority()} | ";

        if ($event->getParam1()) {
            echo " {$event->getParam1()} | ";
        }

        if ($event->getParam2()) {
            echo " {$event->getParam2()} | ";
        }

        echo PHP_EOL;
    }
}
