<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw6\SocketChat;

abstract class ChatEntity
{
    abstract public function run();

    protected function throwSocketException($obSocket, $sSocketFuncName)
    {
        throw new \Exception("Не удалось выполнить " . $sSocketFuncName . "().\nПричина: " . socket_strerror(socket_last_error($obSocket)) . "\n");
    }

    protected function readConfigFile()
    {
        $sCongigFilePath = __DIR__ . "/../../config.ini";

        if(!file_exists($sCongigFilePath))
        {
            throw new \Exception("Не задан путь к файлу Unix сокета в config.ini");
        }

        return parse_ini_file($sCongigFilePath);
    }

    protected function getUnixSocketFilePath()
    {
        $settings = $this->readConfigFile();

        if(empty($settings["unix_socket_file_path"])) {
            throw new \Exception("Не задан путь к файлу Unix сокета в config.ini");
        }

        return $settings["unix_socket_file_path"];
    }
}
