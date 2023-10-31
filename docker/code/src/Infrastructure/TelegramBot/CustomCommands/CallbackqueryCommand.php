<?php


namespace Longman\TelegramBot\Commands\SystemCommands;

use IilyukDmitryi\App\Application\Dto\JoinPurchaseRequestDto;
use IilyukDmitryi\App\Application\UseCase\AddPurchaseUseCase;
use IilyukDmitryi\App\Domain\Exception\UserException;
use IilyukDmitryi\App\Infrastructure\TelegramBot\CallbackController;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class CallbackqueryCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Handle the callback query';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws \Exception
     */
    public function execute(): ServerResponse
    {
        $callback_query = $this->getCallbackQuery();
        
        try {
            $callbackController = new CallbackController($callback_query);
            return $callbackController->getCallback()->run($this);
        } catch (\Throwable $th) {
            if ($th instanceof UserException) {
                $msg = $th->getMessage();
            } else {
                $msg = "Попробуйте еще раз, введите название и через пробел стоимость числом";
            }
        }
        
        return $callback_query->answer([
            'text'       => $msg,
            'show_alert' => true,//(bool) random_int(0, 1), // Randomly show (or not) as an alert.
            'cache_time' => 0,
        ]);
    }
}
