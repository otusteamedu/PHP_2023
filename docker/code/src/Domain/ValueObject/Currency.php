<?php


namespace IilyukDmitryi\App\Domain\ValueObject;

class Currency
{
    const DIVIDER = 100;
    const CURRENCY_NAME = 'руб.';
    
    public function __construct(private readonly int $currency)
    {
    }
    
    function getRaw(): int
    {
        return $this->currency;
    }
    
    function format($addSymbolRub = false)
    {
        $currency = $this->currency / 100;
        if(fmod($currency, 1) != 0){
            $decimal = 2;
        }else{
            $decimal = 0;
        }
        $format = number_format($currency, $decimal, '.', " ");
        
        if ($addSymbolRub) {
            $format .= " ".self::CURRENCY_NAME;
        }
        
        return $format;
    }
    
    public static function getFromRuble(float|int|string $value): ?self
    {
        if (is_string($value)) {
            $value = preg_replace('/\s+/', "", $value);
            preg_match('/\d+(\.\d+)?/', $value, $matches);
            if ($matches[0]) {
                $value = (float)$matches[0];
            } else {
                return null;
            }
        }
        $value = (int)($value * static::DIVIDER);
        return new self($value);
    }
}