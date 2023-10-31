<?php


namespace IilyukDmitryi\App\Infrastructure\TelegramBot\Callback;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\ServerResponse;

interface CallbackInterface
{
     const CALLBACK_PARAM_NAME = 'cmd';
     
     public static function getCallbackName(): string;
     public static function getButtonText(): string;
    public function getCallbackData(): array;
    public function setData(array $data): void;
    public function run(SystemCommand $systemCommand): ServerResponse;
}