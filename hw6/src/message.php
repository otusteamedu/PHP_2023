<?php
declare(strict_types=1);

namespace Elena\Hw6;

class Message
{

    public function get_message()
    {
        $line = readline("Enter your message : ");
        readline_add_history($line);
        return $line;
    }

}
