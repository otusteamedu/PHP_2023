<?php
declare(strict_types=1);

namespace Elena\Hw6;

use Exception;

class Socket
{
    public function __construct(){
        if (!$config = parse_ini_file(dirname(__DIR__, 1).'/config/socket.ini', true)) {
            throw new RuntimeException('There is no socket configuration file!');
        }
        $this->socketFile = dirname(__DIR__, 1).($config['socketFile']??'/socket/socket.sock');
        $this->socketBytes = intval($config['socketBytes']??'1024');
        $this->max_connect = intval($config['max_connect']??'10');

    }

   public function create(){
        $socket = socket_create(AF_UNIX, SOCK_STREAM, SOL_SOCKET);
        if ($socket === false) {
            throw new Exception('Socket не создан '. socket_strerror(socket_last_error()) .PHP_EOL);
        }
        return $socket;
    }

    public function bind($socket){

        if (file_exists( $this->socketFile)) {
           unlink($this->socketFile);
        }

       if (($sbind = socket_bind($socket, $this->socketFile)) === false){
            throw new Exception('Socket bind ошибка '. socket_strerror(socket_last_error()) .PHP_EOL);
        }else{
            return $sbind;
        }
    }

    public function listen($socket){
        if (($slisten = socket_listen($socket, $this->max_connect)) === false){
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
            return false;
        }
        if (!file_exists($this->socketFile) || !$conn = socket_connect($socket, $this->socketFile, $port)) {
            return false;
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
            return false;
        }
        else{
            return $message;
        }
    }

    public function recv($socket){
        socket_recv($socket, $message, $this->socketBytes, 0);
        return $message;
    }

    public function close($socket){
        socket_close($socket);
        return true;
    }

}