<?php


namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Builder\EventBuilder;
use IilyukDmitryi\App\Application\Builder\PurchaseBuilder;
use IilyukDmitryi\App\Application\Builder\UserBuilder;
use IilyukDmitryi\App\Application\Dto\EventRequestDto;
use IilyukDmitryi\App\Application\Dto\PurchaseRequestDto;
use IilyukDmitryi\App\Application\Dto\UserRequestDto;
use IilyukDmitryi\App\Application\Result;
use IilyukDmitryi\App\Application\Error;

use IilyukDmitryi\App\Domain\Model\PurchaseModel;
use Throwable;

class AddPurchaseUseCase
{
    public function __construct()
    {
    
    }
    
    public  function exec(
        PurchaseRequestDto $purchaseRequestDto,
        EventRequestDto $eventRequestDto,
        UserRequestDto $userRequestDto
        ): Result {
        $result = new Result();
        try {
            $event = EventBuilder::build($eventRequestDto);
            $user = UserBuilder::build($userRequestDto);
            $purchase = PurchaseBuilder::build($purchaseRequestDto);
            
            $purchase->setUserId($user->getId());
            $purchase->setEventId($event->getId());
            
            $purchaseModel = new PurchaseModel();
            $purchaseResult = $purchaseModel->addPurchase($purchase);
            $result->setData($purchaseResult->toArray());
        } catch (Throwable $th) {
            $result->addError(Error::getFromException($th));
        }
        return $result;
    }
}