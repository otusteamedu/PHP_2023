<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\Worker;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Application
{
    public function run(): void
    {
        $messageReceiver = new MessageReceiver();
        $messageReceiver->run(
            $this->getRabbitConnection(),
            'orders'
        );
    }

    protected function readConfigFile(): array
    {
        $congigFilePath = __DIR__ . "/../../config.ini";

        if (!file_exists($congigFilePath)) {
            throw new \Exception("Отсутствует файл настроек приложения");
        }

        return parse_ini_file($congigFilePath);
    }

    protected function getRabbitConnection(): AMQPStreamConnection
    {
        $settings = $this->readConfigFile();

        $requiredConnectionSettings = [
            "RABBITMQ_DEFAULT_USER",
            "RABBITMQ_DEFAULT_PASS",
            "RABBITMQ_HOST_NAME",
            "RABBITMQ_PORT"
        ];

        foreach ($requiredConnectionSettings as $settingName) {
            if (empty($settings[$settingName])) {
                throw new \Exception("Не задана обязательная настройка " . $settingName . " в файле config.ini");
            }
        }

        return new AMQPStreamConnection(
            $settings['RABBITMQ_HOST_NAME'],
            $settings["RABBITMQ_PORT"],
            $settings["RABBITMQ_DEFAULT_USER"],
            $settings["RABBITMQ_DEFAULT_PASS"]
        );
    }
}
