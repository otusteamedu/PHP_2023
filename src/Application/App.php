<?php

declare(strict_types=1);

namespace Application;

use Vasilaki\Ar\User\Gateways\UserGateway;

final class App
{
    private function run()
    {
        $allUsers = UserGateway::getAllUsers();
        $userById = UserGateway::findById(1);
    }
}