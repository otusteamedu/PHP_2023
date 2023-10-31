<?php


namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Builder\EventBuilder;
use IilyukDmitryi\App\Application\Builder\PurchaseBuilder;
use IilyukDmitryi\App\Application\Builder\UserBuilder;
use IilyukDmitryi\App\Application\Dto\EventRequestDto;
use IilyukDmitryi\App\Application\Dto\JoinPurchaseRequestDto;
use IilyukDmitryi\App\Application\Dto\PurchaseRequestDto;
use IilyukDmitryi\App\Application\Dto\UserRequestDto;
use IilyukDmitryi\App\Application\Error;
use IilyukDmitryi\App\Application\Result;
use IilyukDmitryi\App\Domain\Model\PurchaseModel;
use Throwable;

class JoinToPurchaseUseCase
{
    public function __construct()
    {
    
    }
    
    public  function exec(
        int  $purchaseId,
        UserRequestDto $userRequestDto
        ): Result {
        $result = new Result();
        try {
            $user = UserBuilder::build($userRequestDto);
            $purchaseModel = new PurchaseModel();
            $joinPurchaseId = $purchaseModel->JoinPurchase($purchaseId,$user->getId());
            $result->setData(['joinPurchaseId' => $joinPurchaseId]);
        } catch (Throwable $th) {
            $result->addError(Error::getFromException($th));
        }
        return $result;
    }
}