<?php

namespace Shabanov\Otusphp\Controller;

use Shabanov\Otusphp\Producer\RabbitMqProducer;
use Shabanov\Otusphp\Render\FormRender;
use Shabanov\Otusphp\Render\FormSuccessRender;

class PageController
{
    public function main(): void
    {
        echo (new FormRender())->show();
    }

    public function formHandler(): void
    {
        if (!empty($_REQUEST['send']) && !empty($_REQUEST['date_from'])) {
            $message = 'Date from: ' . $_REQUEST['date_from'] . ' Date to: ' . $_REQUEST['date_to'];
            (new RabbitMqProducer())->send($message);
            echo (new FormSuccessRender())->show();
        }
    }
}
