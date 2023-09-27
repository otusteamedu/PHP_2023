<?php

use IilyukDmitryi\App\Application\Dto\MessageReciveResult;
use IilyukDmitryi\App\Application\UseCase\ReciveBankStatementUseCase;
use IilyukDmitryi\App\Application\UseCase\ReciveTwoNdflUseCase;
use IilyukDmitryi\App\Infrastructure\Mailers\MailerApp;
use IilyukDmitryi\App\Infrastructure\Messanger\MessengerApp;
use IilyukDmitryi\App\Infrastructure\Storage\StorageApp;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;


$sapi = php_sapi_name();
if ($sapi !== 'cli') {
    throw new \Exception("This script can be run only from command line!");
}
$_SERVER["DOCUMENT_ROOT"]  = dirname(__FILE__,2);
require_once('../vendor/autoload.php');

$messenger = MessengerApp::getMessanger();
$mailer = MailerApp::getMailer();
$eventStorage = StorageApp::getStorage()->getEventStorage();
$reciveBankStatementUseCase = new ReciveBankStatementUseCase($messenger, $mailer, $eventStorage);
$reciveTwoNdflUseCase = new ReciveTwoNdflUseCase($messenger,$mailer,$eventStorage);
$arrUseCases = [
    $reciveBankStatementUseCase,
    $reciveTwoNdflUseCase
];

while(true){
    try {
        foreach($arrUseCases as $useCase){
            /** @var MessageReciveResult $res  */
            $res = $useCase->exec();
            $mess = '';
            if($res->isMessageRecive()){
                $mess = 'Обработано 1 сообщение';
                if($res->isSendEmail()){
                    $mess .= 'Результат отправлен на емаил';
                }else{
                    $mess .= 'Результат не был отправлен на емаил';
                }
                echo $mess.PHP_EOL;
            }
        }
        //sleep(rand(1,3));
    } catch (\Throwable $th){
        if($th instanceof AMQPProtocolChannelException){
            continue;
        }

        echo "\033[0;31m Произошла ошибка: ".$th->getMessage()." ".$th->getFile()." ".$th->getLine()."\033[0m".PHP_EOL;
    }
}


