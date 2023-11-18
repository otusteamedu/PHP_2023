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
            ParameterNames::CONFIG_STORAGE =>  function () {
                return new ConfigStorage();
            },

            ParameterNames::NOTIFY_SERVICE => function () {
                return new NotifyService(new Log(new FileLog()));
            },

            ParameterNames::REPOSITORY => function () {
                return new Repository(new Log(new FileLog()));
            },

            ParameterNames::EVENT_CONTROLLER => function () {
                return new EventController(
                    new StringParameterFromRequest(),
                    new Log(new FileLog()),
                );
            }
        ];
    }
}
