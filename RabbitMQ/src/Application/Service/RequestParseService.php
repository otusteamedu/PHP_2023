<?php

namespace App\Application\Service;

use App\Application\Dto\TransactionsInfoDto;
use App\Application\Service\Exception\MissedParamException;
use App\Entity\Exception\ChatIdNotValidException;
use App\Entity\ValueObject\ChatId;
use App\Infrastructure\Constants;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class RequestParseService
{
    /**
     * @throws MissedParamException
     * @throws ChatIdNotValidException
     * @throws Exception
     */
    public function getTransactionInfoByRequest(Request $request): TransactionsInfoDto
    {
        if ((array_key_exists(Constants::DATE_FROM, $request->toArray()) === false) ||
            (array_key_exists(Constants::DATE_TO, $request->toArray()) === false)) {
            throw new MissedParamException('Date from and date to are required');
        }

        if (array_key_exists(Constants::CHAT_ID, $request->toArray()) === false) {
            throw new MissedParamException('Chat id is required');
        }

        $chatId = new ChatId($request->toArray()['chatId']);
        $dateTo = new DateTime($request->toArray()[Constants::DATE_TO]);
        $dateFrom = new DateTime($request->toArray()[Constants::DATE_FROM]);

        return new TransactionsInfoDto($dateFrom, $dateTo, $chatId->getValue());
    }
}
