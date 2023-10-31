<?php


namespace IilyukDmitryi\App\Application\Builder;

use IilyukDmitryi\App\Application\Dto\PurchaseRequestDto;
use IilyukDmitryi\App\Domain\Entity\Purchase;
use IilyukDmitryi\App\Domain\Exception\UserException;
use IilyukDmitryi\App\Domain\ValueObject\Currency;

class PurchaseBuilder
{
    public static function build(PurchaseRequestDto $purchaseRequestDto): Purchase
    {
        $name = trim($purchaseRequestDto->getName());
        $cost =  Currency::getFromRuble($purchaseRequestDto->getCost());
        
        if($name === ''){
            throw new UserException("Введите название")  ;
        }
        if(!$cost){
            throw new UserException("Не правильная сумма")  ;
        }
        
        return (new Purchase())->setCost($cost)->setName($name);
    }
}