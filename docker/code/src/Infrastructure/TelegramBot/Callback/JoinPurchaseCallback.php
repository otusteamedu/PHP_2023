<?php


namespace IilyukDmitryi\App\Infrastructure\TelegramBot\Callback;

use IilyukDmitryi\App\Application\Dto\JoinPurchaseRequestDto;
use IilyukDmitryi\App\Application\Result;
use IilyukDmitryi\App\Application\UseCase\JoinToPurchaseUseCase;
use IilyukDmitryi\App\Domain\Entity\Purchase;
use IilyukDmitryi\App\Infrastructure\TelegramBot\Builder\EventDtoBuilder;
use IilyukDmitryi\App\Infrastructure\TelegramBot\Builder\UserDtoBuilder;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\ServerResponse;

class JoinPurchaseCallback extends AbstractCallback
{
    const CALLBACK_NAME = 'JoinPurchase';
    const BUTTON_TEXT = 'Присоединиться';
    
    protected array $fieldsParams = [
        "purchase_id" => ["required" => true],
        "user_id" => ["required" => false],
    ];
    
    
    /**
     * @throws \Exception
     */
    public function run(SystemCommand $systemCommand): ServerResponse
    {
        
        $callbackQuery = $systemCommand->getCallbackQuery();
        $callback_data = $callbackQuery->getData();
        
        parse_str($callback_data, $callbackData);
        $this->setData($callbackData);
        $callbackData = $this->getCallbackData();
        $purchaseId = $callbackData['purchase_id'];
        $userRequestDto = UserDtoBuilder::buildFromCallback($callbackQuery);
        
        $joinPurchaseUseCase = new JoinToPurchaseUseCase();
        $resultExec = $joinPurchaseUseCase->exec($purchaseId, $userRequestDto);
        if ($resultExec->isSuccess()) {
            $data = $resultExec->getData();
            $result = $this->sendSuccessJoinPurchase($callbackQuery);
            return $result;
        } else {
            $resultExec->throw();
        }
    }
    
    private function sendSuccessJoinPurchase(CallbackQuery $callbackQuery): ServerResponse
    {
        return $callbackQuery->answer([
            'text'       => 'Вы присоединились',
            'show_alert' => true,//(bool) random_int(0, 1), // Randomly show (or not) as an alert.
            'cache_time' => 0,
        ]);
    }
}