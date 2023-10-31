<?php


namespace IilyukDmitryi\App\Infrastructure\TelegramBot;

use IilyukDmitryi\App\Infrastructure\TelegramBot\Callback\CallbackInterface;
use Longman\TelegramBot\Entities\CallbackQuery;

class CallbackController
{

    
    public function __construct(protected CallbackQuery $callbackQuery)
    {
    
    }
    
    /**
     * @throws \Exception
     */
    public function getCallback(): CallbackInterface
    {
        $callback_data  = $this->callbackQuery->getData();
        parse_str($callback_data, $callbackData);
        $cmdName = CallbackInterface::CALLBACK_PARAM_NAME;
        $callbackName = $callbackData[$cmdName];
        if(empty($callbackName)){
            throw new \Exception("Empty callback name");
        }
        $callbackClass = $this->getCallbackClassFullName($callbackName);
        if (class_exists($callbackClass)) {
            /** @var CallbackInterface $callback */
            $callback = new $callbackClass();
            return $callback;
        }
        throw new \Exception("Callback $callbackClass class not found");
    }
    
    private function getCallbackClassFullName(string $callbackName): string
    {
        $fullClassName = CallbackInterface::class;
        $namespaceEnd = strrpos($fullClassName, '\\');
        return substr($fullClassName, 0, $namespaceEnd).'\\'.$callbackName.'Callback';
    }
}