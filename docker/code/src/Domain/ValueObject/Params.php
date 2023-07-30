<?php

namespace IilyukDmitryi\App\Domain\ValueObject;

class Params
{
    protected array $value;
    
    private function __construct(array $params)
    {
        $this->value = static::sanitizeParams($params);
    }
    
    private static function sanitizeParams(array $arParams): array
    {
        $params = [];
        foreach ($arParams as $param) {
            $param = (int)htmlspecialchars(trim($param));
            if ($param > 0) {
                $params[] = (string)$param;
            }
        }
        return $params;
    }
    
    public static function createFromStr(string $strParams): self
    {
        $params = explode(',', $strParams);
        return new self($params);
    }
    
    public static function createFromArray(array $params): self
    {
        return new self($params);
    }
    
    public function getValue(): array
    {
        return $this->value;
    }
    
    public function getValueString(): string
    {
        return implode(',', $this->value);
    }
}
