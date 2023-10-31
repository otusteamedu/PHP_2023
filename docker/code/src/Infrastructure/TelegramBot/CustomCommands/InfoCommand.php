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
use IilyukDmitryi\App\Application\UseCase\GetInfoEventUseCase;
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

class InfoCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'info';
    
    /**
     * @var string
     */
    protected $description = 'result calculation purchase';
    
    /**
     * @var string
     */
    protected $usage = '/info';
    
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
            $data['reply_markup'] = Keyboard::forceReply(['selective' => true]);
        }
        try {
            $addPurchaseUseCase = new GetInfoEventUseCase();
            $resultExec = $addPurchaseUseCase->exec($chatId);
            if ($resultExec->isSuccess()) {
                $data = $resultExec->getData();
                $result = $this->sendInformation($data);
                return $result;
            } else {
                $resultExec->throw();
            }
        } catch (\Throwable $th) {
            if ($th instanceof UserException) {
                $errorMsg = $th->getMessage();
            } else {
                $errorMsg = "Произошла ошибка";
            }
            $result = $this->sendErrorAddPurchase($errorMsg);
        }
        return $result;
    }
    
    /**
     * @throws TelegramException
     * @throws \Exception
     */
    private function sendInformation(array $arrPurchase): ServerResponse
    {
        $message = F::bold('Покупки:')."\n";
        $t = str_repeat("\t", 5);
        if (!$arrPurchase) {
            $message .= $t.F::italic("-= нет =-\n");
        } else {
            foreach ($arrPurchase as $purchase) {
                $message .=F::underline( F::bold($purchase['user']['name']).": ". $purchase['name']." - ".$purchase['cost'])."\n";
                
                if (!$purchase['joinUsers']) {
                    $message .= $t.F::italic("Нет присоединившихся :-(")."\n\n";
                } else {
                    foreach ($purchase['joinUsers'] as $user) {
                        $message .= $t.$user['name'].",";
                    }
                    $message = rtrim($message, ", ");
                    $message .= "\n\n";
                }
               
            }
        }
        $result = $this->replyToChat($message, [
            'parse_mode' => 'html',
        ]);
        
        return $result;
    }
    
    /**
     * @throws TelegramException
     */
    private function sendErrorAddPurchase(string $msg): ServerResponse
    {
        return $result = $this->replyToChat($msg, [
        ]);
    }
}
