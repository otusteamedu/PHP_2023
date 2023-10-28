<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\Worker;

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
            $orderId = $msgParams["orderId"];
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
            try {
                $this->sendFileToApi(
                    $this->makeStatementFile($paymentsNumber, (int) $orderId, $statementNumber),
                    (int) $orderId
                );
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit(1);
            }
            echo 'отправляем брокеру подтверждение, что сообщение успешно обработано. Это сообщение будет удалено из очереди.' . PHP_EOL;
            $msg->ack();
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queueName, '', false, false, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    protected function makeStatementFile(int $paymentsNumber, int $orderId, string $statementNumber): string
    {
        $fileDirectory = "/data/mysite.local/public/statements/";
        $fileName = md5(time() . $orderId . rand(0, 100000)) . "_statement_" . $orderId . ".txt";
        var_dump($fileName);
        $statementFileContents = "Выписка по счёту: " . $statementNumber . PHP_EOL;
        $totalSumm = 0;
        for ($i = 0; $i < $paymentsNumber; $i++) {
            $operationDate = time() - ($paymentsNumber - $i) * 3600 * 24;
            $operationDate = date("Y.m.d", $operationDate);
            $operationSumm = rand(0, 500000) / 100;
            if ((rand(0, 10) % 2) == 1) {
                $operationSumm *= -1;
            }
            $totalSumm += $operationSumm;
            $statementFileContents .= implode(";", [$operationDate, $operationSumm]) . PHP_EOL;
        }
        $statementFileContents .= "Текущий баланс счета: " . $totalSumm . PHP_EOL;
        file_put_contents($fileDirectory . $fileName, $statementFileContents, FILE_APPEND);
        return $fileName;
    }

    protected function sendFileToApi(string $statementFileName, int $orderId): void
    {
        $ch = curl_init("http://mysite.local/api/v1/statement/order/");

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            json_encode(
                [
                    "orderId" => $orderId,
                    "fileName" => $statementFileName,
                    "status" => "completed"
                ],
                JSON_UNESCAPED_UNICODE
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            throw new \Exception("Произошла ошибка в отправке запроса через CURL" . curl_error($ch) . PHP_EOL);
        }
        curl_close($ch);

        $decodedResponse = json_decode($response, true);
        if (
            !isset($decodedResponse["success"])
            || ($decodedResponse["success"] != true)
        ) {
            throw new \Exception("Не удалось поменять статус заказа. Ответ от API:" . $response . PHP_EOL);
        }
    }
}
