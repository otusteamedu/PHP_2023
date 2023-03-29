<?php

declare(strict_types=1);

namespace Aporivaev\Hw09;

class Client extends AppSocket
{
    private ?string $name;
    private int $nameIndexLen = 5;


    /** @throws /Exception */
    public function __construct(string $fileName, string $name = null)
    {
        parent::__construct($fileName);
        $this->name = $name;

        if (empty($this->name)) {
            $this->name = 'Client_' . bin2hex(random_bytes($this->nameIndexLen));
        }
        $this->clientConnect($this->name);
    }

    /** @throws /Exception */
    public function run()
    {
        $end = false;
        $inBuffer = '';
        while (!$end) {
            if ($this->readStdIn($inBuffer)) {
                $end = $inBuffer === $this->commandQuit;
                $this->write($inBuffer);
                $inBuffer = '';
            }

            if ($input = $this->read()) {
                echo "Server: $input\n";
            }

        }
    }
}
