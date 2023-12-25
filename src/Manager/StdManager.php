<?php

namespace WorkingCode\Hw6\Manager;

use WorkingCode\Hw6\Exception\StdoutException;

class StdManager
{
    /**
     * @throws StdoutException
     */
    public function stdPrint(string $message): void
    {
        $message .= "\n";
        $result  = fwrite(STDOUT, $message, strlen($message));

        if ($result === false) {
            throw new StdoutException('error write message: ' . $message);
        }
    }

    public function getStdin(): string
    {
        return trim(fgets(STDIN));
    }
}
