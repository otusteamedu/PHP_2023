<?php


namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Builder\EventBuilder;
use IilyukDmitryi\App\Application\Builder\PurchaseBuilder;
use IilyukDmitryi\App\Application\Builder\UserBuilder;
use IilyukDmitryi\App\Application\Dto\EventRequestDto;
use IilyukDmitryi\App\Application\Dto\PurchaseRequestDto;
use IilyukDmitryi\App\Application\Dto\UserRequestDto;
use IilyukDmitryi\App\Application\Error;
use IilyukDmitryi\App\Application\Result;
use IilyukDmitryi\App\Domain\Entity\Purchase;
use IilyukDmitryi\App\Domain\Model\EventModel;
use IilyukDmitryi\App\Domain\Model\PurchaseModel;
use IilyukDmitryi\App\Domain\Model\UserModel;
use Throwable;

class GetInfoEventUseCase
{
    public function __construct()
    {
    }
    
    public  function exec(int $eventId): Result {
        $result = new Result();
        try {
          
            $purchaseModel = new PurchaseModel();
            $userModel = new UserModel();
            $purchases = $purchaseModel->getPurchasesByEventId($eventId);
            $arPurchase = [];
            /** @var Purchase $purchase */
            foreach ($purchases as $purchase) {
                $arr =  $purchase->toArray();
                $arr['user'] = $userModel->getUserById($purchase->getUserId())->toArray();
                $arPurchase[] = $arr;
            }
            $result->setData($arPurchase);
        } catch (Throwable $th) {
            $result->addError(Error::getFromException($th));
        }
        return $result;
    }
}