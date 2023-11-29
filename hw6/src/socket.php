<?php
declare(strict_types=1);

namespace Elena\Hw6;

use Exception;

class Socket
{
    private $socketFile = "./socket/socket.sock";
    private $socketBytes = 1024;

    public function create(){
      // if (file_exists($this->socketFile)) unlink($this->socketFile);

        $socket = socket_create(AF_UNIX, SOCK_STREAM, SOL_SOCKET);
        if ($socket === false) {
            throw new Exception('Socket не создан '. socket_strerror(socket_last_error()) .PHP_EOL);
        }
        return $socket;
    }

    public function bind($socket){
        if (($sbind = socket_bind($socket, $this->socketFile)) === false){
            throw new Exception('Socket bind ошибка '. socket_strerror(socket_last_error()) .PHP_EOL);
        }else{
            return $sbind;
        }
    }

    public function listen($max_connect){
        if (($slisten = socket_listen($this->socket, $max_connect)) === false){
            throw new Exception('Socket listen ошибка '. socket_strerror(socket_last_error()) .PHP_EOL);
        }else{
            return $slisten;
        }
    }

    public function accept($socket){
        return socket_accept($socket);
    }

    public function connect($socket,$port = null){
        if (!isset($socket)) {
            throw new Exception('Socket не обозначен'. socket_strerror(socket_last_error()) .PHP_EOL);
        }
        if (!$conn = socket_connect($socket, $this->socketFile, $port)) {
            throw new Exception('Нет подключения к Socket'. socket_strerror(socket_last_error()) .PHP_EOL);
        }
        return $conn;
    }

    public function read($socket){
        $data = socket_read($socket, $this->socketBytes);
        if (!$data) {
            throw new Exception('Не читаемый socket'. socket_strerror(socket_last_error()) .PHP_EOL);
        }
        return $data;
    }

    public function write($socket, $message){
        if (!socket_write($socket, $message, strlen($message))) {
            throw new Exception('Нельзя записать socket'. socket_strerror(socket_last_error()) .PHP_EOL);
        }
        return true;
    }

    public function recv($socket,$message){
        socket_recv($socket, $message, $this->socketBytes, 0);
        return $message;
    }

    public function close($socket){
        socket_close($socket);
        return true;
    }

}