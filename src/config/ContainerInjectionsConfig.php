<?php

namespace src\config;

use src\application\api\EventController;
use src\infrastructure\log\FileLog;
use src\infrastructure\log\Log;
use NdybnovHw03\CnfRead\ConfigStorage;
use src\application\notify\NotifyService;
use src\application\portAdapter\StringParameterFromRequest;
use src\infrastructure\repository\Repository;

class ContainerInjectionsConfig
{
    public static function describes(): array
    {
        return [
            ParameterNames::ConfigStorage =>  function () {
                return new ConfigStorage();
            },

            ParameterNames::NotifyService => function () {
                return new NotifyService(new Log(new FileLog()));
            },

            ParameterNames::Repository => function () {
                return new Repository(new Log(new FileLog()));
            },

            ParameterNames::EventController => function () {
                return new EventController(
                    new StringParameterFromRequest(),
                    new Log(new FileLog()),
                );
            }
        ];
    }
}
