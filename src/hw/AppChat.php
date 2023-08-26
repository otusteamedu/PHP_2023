<?php

namespace Ndybnov\Hw05\hw;

error_reporting(E_ERROR);

class AppChat
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function run(): void
    {
        Validate::availableSocketFunctions();

        $parameters = ArgumentsCommandLine::getParameters();

        $typeApp = $parameters->get('type');
        Validate::checkArgumentType($typeApp);

        $debugParameter = $parameters->get('cmd');


        $netChatApp = NetChatApp::build()->create($typeApp);

        try {
            $netChatApp->startSocket();
            $netChatApp->refreshSocket($debugParameter);
        } catch (\Exception $exception) {
            throw new $exception($exception->getMessage());
        }

        try {
            $netChatApp->bindSocket();

            $netChatApp->startWaiting();
            while ($netChatApp->isWait()) {
                $netChatApp->setBockModeSocket();

                $netChatApp->getMessage();

                $netChatApp->message();

                $netChatApp->confirm();

                $netChatApp->determineNeedToWait();
            }
        } catch (\Exception $exception) {
            $netChatApp->stopSocket();
            throw new $exception($exception->getMessage());
        }
    }
}
