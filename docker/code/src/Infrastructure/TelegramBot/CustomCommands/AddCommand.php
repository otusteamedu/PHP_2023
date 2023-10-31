<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 * (c) PHP Telegram Bot Team
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Start command
 * Gets executed when a user first starts using the bot.
 * When using deep-linking, the parameter can be accessed by getting the command text.
 * @see https://core.telegram.org/bots#deep-linking
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use IilyukDmitryi\App\Application\UseCase\AddPurchaseUseCase;
use IilyukDmitryi\App\Domain\Exception\UserException;
use IilyukDmitryi\App\Infrastructure\TelegramBot\Builder\EventDtoBuilder;
use IilyukDmitryi\App\Infrastructure\TelegramBot\Builder\UserDtoBuilder;
use IilyukDmitryi\App\Infrastructure\TelegramBot\Callback\JoinPurchaseCallback;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use IilyukDmitryi\App\Application\Dto;
use IilyukDmitryi\App\Domain\ValueObject\Currency;

class AddCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'add';
    
    /**
     * @var string
     */
    protected $description = 'add event';
    
    /**
     * @var string
     */
    protected $usage = '/add';
    
    /**
     * @var string
     */
    protected $version = '1.2.0';
    
    /**
     * @var bool
     */
    protected $private_only = false;
    
    /**
     * @var bool
     */
    protected $need_mysql = true;
    
    /**
     * Conversation Object
     * @var Conversation
     */
    protected $conversation;
    
    
    /**
     * Main command execution
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        // If you use deep-linking, get the parameter like this:
        // $deep_linking_parameter = $this->getMessage()->getText(true);
        //$this->executeC()
        
        $message = $this->getMessage();
        
        $chat = $message->getChat();
        $user = $message->getFrom();
        $text = trim($message->getText(true));
        $chatId = $chat->getId();
        $chatName = $chat->getFirstName().' *'.$chat->getLastName().' *'.$chat->getTitle();
        $userName = $user->getUsername();
        $userId = $user->getId();
        
        $message->getMessageId();
        
        // Preparing response
        $data = [
            'chat_id' => $chatId,
            // Remove any keyboard by default
            'reply_markup' => Keyboard::remove(['selective' => true]),
        ];
        
        if ($chat->isGroupChat() || $chat->isSuperGroup()) {
            // Force reply is applied by default so it can work with privacy on
            $data['reply_markup'] = Keyboard::forceReply(['selective' => true]);
        }
        
        // Conversation start
        $this->conversation = new Conversation($userId, $chatId, $this->getName());
        // Load any existing notes from this conversation
        $notes = &$this->conversation->notes;
        !is_array($notes) && $notes = [];
        
        $state = $notes['state'] ?? 0;
        
        $result = Request::emptyResponse();
        
        switch ($state) {
            case 0:
                if ($text === '') {
                   /* Request::deleteMessage([
                        'chat_id' => $chat->getId(),
                        'message_id' => $message->getMessageId(),
                    ]);*/
                    $notes['state'] = 0;
                    $data['text'] = 'Введите  название и потраченную сумму числом:';
                    $data['reply_markup'] = Keyboard::forceReply();
                    $result = Request::sendMessage($data);
                    $notes['delete_message'] = $result->getResult()->getMessageId();
                    $this->conversation->update();
                    break;
                }
                
                $notes['answer_purchase_text'] = $text;
                $text = '';
            
            // No break!
            case 1:
                if ($text === '') {
                    /* Request::deleteMessage([
                         'chat_id' => $chat->getId(),
                         'message_id' => $message->getMessageId(),
                     ]);
                     
                     Request::deleteMessage([
                         'chat_id' => $chat->getId(),
                         'message_id' => $notes['delete_message'],
                     ]);*/
                    unset($notes['state']);
                    
                try {
                    $arPurchaseData = $this->getPurchaseDataFromText($notes['answer_purchase_text'] );
   
                    if ($arPurchaseData['name'] && !is_null($arPurchaseData['cost'])) {
                        $purchaseRequestDto = new Dto\PurchaseRequestDto(
                            $arPurchaseData['name'],
                            $arPurchaseData['cost']
                        );
                        
                        $userDto = UserDtoBuilder::buildFromMessage($message);
                        $eventDto = EventDtoBuilder::buildFromMessage($message);
                        
                        $addPurchaseUseCase = new AddPurchaseUseCase();
                        $resultExec = $addPurchaseUseCase->exec($purchaseRequestDto, $eventDto, $userDto);
                        if ($resultExec->isSuccess()) {
                            $this->conversation->stop();
                            $data = $resultExec->getData();
                            $result = $this->sendSuccessAddPurchase($data['id'], $data['name'],$data['cost']);
                            return $result;
                        } else {
                            $resultExec->throw();
                        }
                    }
                } catch (\Throwable $th) {
                    if ($th instanceof UserException) {
                        $errorMsg = $th->getMessage();
                    } else {
                        $errorMsg = "Попробуйте еще раз, введите название и через пробел стоимость, числом";
                    }
                    $result = $this->sendErrorAddPurchase($errorMsg);
                }
                    
                    break;
                }
                
        }
        
        return $result;
        /*return $this->replyToChat(
            'Введите  название и потраченную сумму числом1',
            [
                'reply_markup' => Keyboard::forceReply(),
            ]
        );*/
    }
    
    /**
     * @return array{"name": string, "cost": ?Currency}
     */
    private function getPurchaseDataFromText(string $text): array
    {
        $arPurchaseData = [];
        preg_match_all(
            '/(?P<name>[а-яa-z\s]+)\s+(?P<value>\d+([\.\,\s]\d+)?)(\s+(?P<currency>[а-я]+))*/uim',
            $text,
            $matches
        );
        
        if (!empty($matches['name']) && !empty($matches['value'])) {
            $lastIndex = count($matches['name']) - 1;
            $arPurchaseData['name'] = $matches['name'][$lastIndex];
            $arPurchaseData['cost'] = $matches['value'][$lastIndex];
        } else {
            throw new \Exception("Не удалось распарсить данные");
        }
        return $arPurchaseData;
    }
    
    /**
     * @throws TelegramException
     * @throws \Exception
     */
    private function sendSuccessAddPurchase(int $purchaseId, string $purchaseName,string $purchaseCost): ServerResponse
    {
        $joinPurchaseCallback = new JoinPurchaseCallback();
        $joinPurchaseCallback->setData([
            'purchase_id' => $purchaseId,
        ]);
        $arParams = $joinPurchaseCallback->getCallbackData();
        /*$arParams = [
            'cmd' => 'JoinPurchaseCallback',
            'purchase_id' => $purchaseId,
        ];*/
        $inline_keyboard = new InlineKeyboard([
            ['text' => $joinPurchaseCallback::BUTTON_TEXT, 'callback_data' => http_build_query($arParams)],
        ]);
        
        $result = $this->replyToChat($purchaseName." ".$purchaseCost, [
            'reply_markup' => $inline_keyboard,
        ]);
        return $result;
    }
    
    /**
     * @throws TelegramException
     */
    private function sendErrorAddPurchase(string $msg): ServerResponse
    {
        $message = $this->getMessage();
        if ($message = $this->getMessage() ?: $this->getEditedMessage()) {
            return Request::sendMessage(array_merge([
                'chat_id' => $message->getFrom()->getId(),
                'text'    => $msg,
                
            ], $data = [
                'show_alert' => 1,//(bool) random_int(0, 1), // Randomly show (or not) as an alert.
                'cache_time' => 0,
            ]));
        }
        return $result;
    }
}
