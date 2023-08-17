<?php

declare(strict_types=1);

namespace Art\Code\Application\UseCase;

use Art\Code\Domain\Model\Event;
use Art\Code\Domain\Model\Response;
use Art\Code\Domain\Model\Storage;
use JsonException;

class PostUseCase implements PostInterface
{
    public function __construct(private readonly Storage $storage)
    {
    }

    /**
     * @return Response
     * @throws JsonException
     */
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

    /**
     * @return bool
     * @throws JsonException
     */
    private function addEvent(): bool
    {
        if (isset($_POST['event'], $_POST['priority'], $_POST['conditions'])) {
            if (!is_array($_POST['conditions'])) {
                echo ('Isn`t array!');
            }

            $event = new Event($_POST);

            $this->storage->add($event);

            return true;
        }

        return false;
    }

    /**
     * @return false|mixed
     */
    private function findEvent(): mixed
    {
        if (isset($_POST['params']) && is_array($_POST['params'])) {
            return $this->storage->find($_POST['params']);
        }

        return false;
    }
}
