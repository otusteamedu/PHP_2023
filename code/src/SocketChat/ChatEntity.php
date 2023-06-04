<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw6\SocketChat;

abstract class ChatEntity
{
    abstract public function run();

    public function throwSocketException($obSocket, $sSocketFuncName) {
        throw new \Exception("Не удалось выполнить " . $sSocketFuncName . "().\nПричина: " . socket_strerror(socket_last_error($obSocket)) . "\n");
    }
}
