<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw6\Chat;

class Client extends Base
{
    const TIMEOUT = 5;

    public function run()
    {
        while (($line = fgets(STDIN)) !== false) {
            $fp = stream_socket_client(
                $this->getServerAddress(),
                $errno,
                $errstr,
                self::TIMEOUT
            );

            if (!$fp) {
                http_response_code($errno);
                throw new \Exception($errstr);
            }

            fwrite($fp, $line);
            while (!feof($fp)) {
                $data = fgets($fp, static::MESSAGE_LENGTH);
                if (!$data) {
                    continue;
                }
                fwrite(STDOUT, $data);
            }
            fclose($fp);
        }
    }
}
