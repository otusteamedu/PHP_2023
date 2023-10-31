<?php


namespace IilyukDmitryi\App\Infrastructure\TelegramBot\Callback;

use Longman\TelegramBot\Entities\CallbackQuery;

abstract class AbstractCallback implements CallbackInterface
{
    /**
     * @var array{array{bool:"required",mixed:"value"}}
     */
    protected array $fieldsParams = [];
    protected array $fieldsData = [];
    
    
    public static function getCallbackName(): string
    {
        return static::CALLBACK_NAME;
    }
    
    public static function getButtonText(): string
    {
        return static::BUTTON_TEXT;
    }
    
    public function getCallbackData(): array
    {
        return array_merge($this->fieldsData, [static::CALLBACK_PARAM_NAME => static::getCallbackName()]);
    }
    
    /**
     * @throws \Exception
     */
    public function setData(array $data): void
    {
        $fields = &$this->fieldsParams;
        
        foreach ($fields as $fieldName => $fieldData) {
            if (isset($data[$fieldName])) {
                $this->fieldsData[$fieldName] = $data[$fieldName];
            } else {
                if ($fields['required']) {
                    throw new \Exception("Field {$fieldName} is required");
                }
            }
        }
    }
}