<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw19\AccountStatement;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class MessageReceiver
{
    public function run(AMQPStreamConnection $connection, string $queueName): void
    {
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);

        echo "Ожидаем сообщения из очереди." . PHP_EOL;

        $callback = function ($msg) {
            echo 'Получено сообщение. Тело сообщения: ' . $msg->body . PHP_EOL;
            $msgParams = json_decode($msg->body, true);
            $statementNumber = $msgParams["statementNumber"];
            $orderId = $msgParams["id"];
            $number = mb_substr(
                $statementNumber,
                (mb_strpos($statementNumber, "/") + 1)
            );
            echo 'Подгружаем данные по счету клиента' . PHP_EOL;
            echo 'Номер договора: ' . $number . PHP_EOL;
            $paymentsNumber = ($number % 25);
            echo 'Количество записей в выписке = ' . $paymentsNumber . PHP_EOL;
            sleep(5);
            echo 'формируем файл с выпиской' . PHP_EOL;
            $this->sendFileToApi(
                $this->makeStatementFile($paymentsNumber, (int) $orderId),
                (int) $orderId
            );
            echo 'отправляем полученную выписку клиенту' . PHP_EOL;
            echo 'отправляем брокеру подтверждение, что сообщение успешно обработано. Это сообщение будет удалено из очереди.' . PHP_EOL;
            $msg->ack();
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queueName, '', false, false, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    protected function makeStatementFile(int $paymentsNumber, int $orderId): string
    {
        $filePath = "/data/mysite.local/statements/statement_" . $orderId . ".txt";
        for ($i = 0; $i < $paymentsNumber; $i++) {
            $date = time() - ($paymentsNumber - $i) * 3600 * 24;
            $date = date("Y.m.d", $date);
            $summ = rand(0, 500000) / 100;
            if (rand(0, 1) === 1) {
                $summ *= -1;
            }
            file_put_contents($filePath, implode(";", [$date, $summ]) . PHP_EOL, FILE_APPEND);
        }
        return $filePath;
    }

    protected function sendFileToApi(string $pathToStatementFile, int $orderId): void
    {
        $ch = curl_init("http://otus-hw-nginx/api/v1/statement/order/" . $orderId . "/");

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            json_encode(
                [
                    "filePath" => $pathToStatementFile,
                    "status" => "completed"
                ],
                JSON_UNESCAPED_UNICODE
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                "Host: mysite.local:80"
            ]
        );
        $response = curl_exec($ch);
        var_dump("response === ", $response );
        if(curl_error($ch)) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);
    }
}
