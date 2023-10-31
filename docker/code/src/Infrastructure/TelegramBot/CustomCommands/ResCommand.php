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
use IilyukDmitryi\App\Application\UseCase\GetActualTransactionEventUseCase;
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
use IilyukDmitryi\App\Infrastructure\TelegramBot\MessageFormatter\HtmlFormatter as F;

class ResCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'res';
    
    /**
     * @var string
     */
    protected $description = 'result calculation purchase';
    
    /**
     * @var string
     */
    protected $usage = '/res';
    
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
    protected $need_mysql = false;
    
    
    /**
     * Main command execution
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
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
        
        try {
            $addPurchaseUseCase = new GetActualTransactionEventUseCase();
            $resultExec = $addPurchaseUseCase->exec($chatId);
            if ($resultExec->isSuccess()) {
                $data = $resultExec->getData();
                $result = $this->sendMessageTransaction($data);
                return $result;
            } else {
                $resultExec->throw();
            }
        } catch (\Throwable $th) {
            if ($th instanceof UserException) {
                $errorMsg = $th->getMessage();
            } else {
                $errorMsg = "Попробуйте еще раз, введите название и через пробел стоимость, числом";
            }
            $result = $this->sendErrorAddPurchase($errorMsg);
        }
        
        return $result;
    }
    
    
    /**
     * @throws TelegramException
     * @throws \Exception
     */
    private function sendMessageTransaction($arTransaction): ServerResponse
    {
        $message = F::bold('Список ожидаемых переводов:')."\n";
        $t = str_repeat("\t", 5);
        if(!$arTransaction['actual']){
            $message .= $t . F::italic("-= долгов нет =-\n");
        }else{
            foreach ($arTransaction['actual'] as $transaction) {
                $message .= $t.$transaction['fromUser']['name'].' -> '.$transaction['toUser']['name'].' - '.$transaction['cost']."\n";
            }
        }
        $message .= "\n".F::bold('Список совершенных переводов:')."\n";
        if(!$arTransaction['done']){
            $message .= F::italic("-= нет =-\n");
        }else{
            foreach ($arTransaction['done'] as $transaction) {
                $message .= $t.$transaction['fromUser']['name'].' -> '.$transaction['toUser']['name'].' - '.$transaction['cost']."\n";
            }
        }
        $result = $this->replyToChat($message, [
            'parse_mode' => 'html',
        ]);
       
        return $result;
    }
    
    private function sendErrorAddPurchase(string $msg): ServerResponse
    {
        return $result = $this->replyToChat($msg, [
        ]);
    }
}
