<?php

declare(strict_types=1);

namespace Art\Code\Service;

use Art\Code\Http\Response;
use Art\Code\Model\Event;
use Art\Code\Storage\StorageInterface;

class PostProcessor
{
    public function __construct(private readonly StorageInterface $storage)
    {
    }

    public function process(): Response
    {
        if (isset($_POST['method'])) {
            switch ($_POST['method']) {

                case 'add':

                    $event = $this->addEvent();

                    if ($event !== false) {
                        return new Response("Event has been saved.");
                    }

                    break;

                case 'find':

                    $event = $this->findEvent();

                    if ($event === false) {
                        return new Response('Nothing was found.');
                    }
                    $eventName = $event['name'];
                    return new Response("Found: `$eventName`");

                case 'clear':

                    $this->storage->clear();

                    return new Response('Storage has been cleaned.');
            }
        }

        return new Response('Bad Request', Response::HTTP_BAD_REQUEST, ['content-type' => 'text/html']);
    }

    private function addEvent(): bool
    {
        if (isset($_POST['event'], $_POST['priority'], $_POST['conditions'])) {

            if (!is_array($_POST['conditions']))
                echo ('Isn`t array!');

            $event = new Event($_POST);

            $this->storage->add($event);

            return true;
        }

        return false;
    }

    private function findEvent()
    {
        if (isset($_POST['params']) && is_array($_POST['params'])) {
            return $this->storage->find($_POST['params']);;
        }

        return false;
    }
}
