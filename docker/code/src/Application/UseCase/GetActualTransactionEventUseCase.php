<?php


namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Builder\EventBuilder;
use IilyukDmitryi\App\Application\Builder\PurchaseBuilder;
use IilyukDmitryi\App\Application\Builder\UserBuilder;
use IilyukDmitryi\App\Application\Error;
use IilyukDmitryi\App\Application\Result;
use IilyukDmitryi\App\Domain\Entity\Transaction;
use IilyukDmitryi\App\Domain\Model\EventModel;
use IilyukDmitryi\App\Domain\Model\PurchaseModel;
use IilyukDmitryi\App\Domain\Model\UserModel;
use Throwable;

class GetActualTransactionEventUseCase
{
    public function __construct()
    {
    }
    
    public  function exec(int $eventId): Result {
        $result = new Result();
        try {
            $eventModel = new EventModel();
            $userModel = new UserModel();
            $transactions = $eventModel->getActualDebtsTransactionByEventId($eventId);
            $arrTransaction = [];
            /** @var Transaction $transaction */
            foreach($transactions as $transaction){
                $arrTtr  = $transaction->toArray();
                $arrTtr['fromUser'] = $userModel->getUserById($transaction->getFromUserId())->toArray();
                $arrTtr['toUser'] = $userModel->getUserById($transaction->gettoUserId())->toArray();
                $arrTransaction[] = $arrTtr;
            }
            
            $arrTransactionDone = [];
            $transactionsDone = $eventModel->getPaidDebtsTransactionByEventId($eventId);
            /** @var Transaction $transaction */
            foreach($transactionsDone as $transaction){
                $arrTtr  = $transaction->toArray();
                $arrTtr['fromUser'] = $userModel->getUserById($transaction->getFromUserId())->toArray();
                $arrTtr['toUser'] = $userModel->getUserById($transaction->gettoUserId())->toArray();
                $arrTransactionDone[] = $arrTtr;
            }
            $result->setData([
                'actual'=>$arrTransaction,
                'done'=>$arrTransactionDone
            ]);
        } catch (Throwable $th) {
            $result->addError(Error::getFromException($th));
        }
        return $result;
    }
}