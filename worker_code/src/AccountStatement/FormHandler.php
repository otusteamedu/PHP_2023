<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw19\AccountStatement;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class FormHandler
{
    public function run(AMQPStreamConnection $connection, string $queueName): string
    {
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        $paramsValidationRules = [
            "accountNumber" => "AccountNumber",
            "dateStart" => "Date",
            "dateEnd" => "Date",
            "email" => "Email"
        ];

        $messageParams = [];
        foreach ($paramsValidationRules as $fieldName => $validateRule) {
            $methodName = "is" . $validateRule . "Valid";
            if ($this->$methodName($_POST[$fieldName])) {
                $messageParams[] = $_POST[$fieldName];
            } else {
                throw new \Exception("Некорректно заполнено поле " . $fieldName);
            }
        }

        $msg = new AMQPMessage(
            json_encode($messageParams, JSON_UNESCAPED_UNICODE),
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $channel->basic_publish($msg, '', $queueName);

        $channel->close();
        $connection->close();

        return "Ваш запрос успешно принят.";
    }

    protected function isAccountNumberValid(string $accountNumber)
    {
        return preg_match("#100000\/\d{5,15}#", $accountNumber);
    }

    protected function isDateValid($date)
    {
        $sFormat = "Y.m.d";
        $obDate = \DateTime::createFromFormat($sFormat, $date);
        return ($obDate && ($obDate->format($sFormat) === $date));
    }

    protected function isEmailValid(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
