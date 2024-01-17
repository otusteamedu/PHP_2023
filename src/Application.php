<?php

declare(strict_types=1);

namespace Santonov\Otus;

use Exception;
use Santonov\Otus\Chat\ChatClient;
use Santonov\Otus\Chat\ChatServer;

final class Application
{
    public function run(array $args): void
    {
        $name = $args[1];
        if ($name === 'server') {
            (new ChatServer())->process();
        } elseif ($name === 'client') {
            (new ChatClient())->process();
        } else {
            throw new Exception('Invalid parameter');
        }
    }
}
